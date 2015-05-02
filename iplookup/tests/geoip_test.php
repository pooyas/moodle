<?php

/**
 * GeoIP tests
 *
 * @package    core_iplookup
 * @category   phpunit
 * @copyright  2012 Petr Skoda {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die();


/**
 * GeoIp data file parsing test.
 */
class core_iplookup_geoip_testcase extends advanced_testcase {

    public function test_geoip() {
        global $CFG;
        require_once("$CFG->libdir/filelib.php");
        require_once("$CFG->dirroot/iplookup/lib.php");

        if (!PHPUNIT_LONGTEST) {
            // this may take a long time
            return;
        }

        $this->resetAfterTest();

        // let's store the file somewhere
        $gzfile = "$CFG->dataroot/phpunit/geoip/GeoLiteCity.dat.gz";
        check_dir_exists(dirname($gzfile));
        if (file_exists($gzfile) and (filemtime($gzfile) < time() - 60*60*24*30)) {
            // delete file if older than 1 month
            unlink($gzfile);
        }

        if (!file_exists($gzfile)) {
            download_file_content('http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz', null, null, false, 300, 20, false, $gzfile);
        }

        $this->assertTrue(file_exists($gzfile));

        $zd = gzopen($gzfile, "r");
        $contents = gzread($zd, 50000000);
        gzclose($zd);

        $geoipfile = "$CFG->dataroot/geoip/GeoLiteCity.dat";
        check_dir_exists(dirname($geoipfile));
        $fp = fopen($geoipfile, 'w');
        fwrite($fp, $contents);
        fclose($fp);

        $this->assertTrue(file_exists($geoipfile));

        $CFG->geoipfile = $geoipfile;

        $result = iplookup_find_location('147.230.16.1');

        $this->assertEquals('array', gettype($result));
        $this->assertEquals('Liberec', $result['city']);
        $this->assertEquals(15.0653, $result['longitude'], '', 0.001);
        $this->assertEquals(50.7639, $result['latitude'], '', 0.001);
        $this->assertNull($result['error']);
        $this->assertEquals('array', gettype($result['title']));
        $this->assertEquals('Liberec', $result['title'][0]);
        $this->assertEquals('Czech Republic', $result['title'][1]);
    }
}

