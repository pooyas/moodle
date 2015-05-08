<?php

/**
 * GeoIP tests
 *
 * @package    core
 * @subpackage iplookup
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die();


/**
 * GeoIp data file parsing test.
 */
class core_iplookup_geoplugin_testcase extends advanced_testcase {

    public function test_geoip() {
        global $CFG;
        require_once("$CFG->libdir/filelib.php");
        require_once("$CFG->dirroot/iplookup/lib.php");

        if (!PHPUNIT_LONGTEST) {
            // we do not want to DDOS their server, right?
            return;
        }

        $this->resetAfterTest();

        $CFG->geoipfile = '';

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

