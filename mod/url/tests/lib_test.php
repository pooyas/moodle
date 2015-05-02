<?php

/**
 * Unit tests for some mod URL lib stuff.
 *
 * @package    mod_url
 * @category   phpunit
 * @copyright  2012 Petr Skoda {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die();


/**
 * mod_url tests
 *
 * @package    mod_url
 * @category   phpunit
 * @copyright  2011 Petr Skoda {@link http://skodak.org}
 * 
 */
class mod_url_lib_testcase extends basic_testcase {

    /**
     * Prepares things before this test case is initialised
     * @return void
     */
    public static function setUpBeforeClass() {
        global $CFG;
        require_once($CFG->dirroot . '/mod/url/locallib.php');
    }

    /**
     * Tests the url_appears_valid_url function
     * @return void
     */
    public function test_url_appears_valid_url() {
        $this->assertTrue(url_appears_valid_url('http://example'));
        $this->assertTrue(url_appears_valid_url('http://www.example.com'));
        $this->assertTrue(url_appears_valid_url('http://www.exa-mple2.com'));
        $this->assertTrue(url_appears_valid_url('http://www.example.com/~nobody/index.html'));
        $this->assertTrue(url_appears_valid_url('http://www.example.com#hmm'));
        $this->assertTrue(url_appears_valid_url('http://www.example.com/#hmm'));
        $this->assertTrue(url_appears_valid_url('http://www.example.com/žlutý koníček/lala.txt'));
        $this->assertTrue(url_appears_valid_url('http://www.example.com/žlutý koníček/lala.txt#hmmmm'));
        $this->assertTrue(url_appears_valid_url('http://www.example.com/index.php?xx=yy&zz=aa'));
        $this->assertTrue(url_appears_valid_url('https://user:password@www.example.com/žlutý koníček/lala.txt'));
        $this->assertTrue(url_appears_valid_url('ftp://user:password@www.example.com/žlutý koníček/lala.txt'));

        $this->assertFalse(url_appears_valid_url('http:example.com'));
        $this->assertFalse(url_appears_valid_url('http:/example.com'));
        $this->assertFalse(url_appears_valid_url('http://'));
        $this->assertFalse(url_appears_valid_url('http://www.exa mple.com'));
        $this->assertFalse(url_appears_valid_url('http://www.examplé.com'));
        $this->assertFalse(url_appears_valid_url('http://@www.example.com'));
        $this->assertFalse(url_appears_valid_url('http://user:@www.example.com'));

        $this->assertTrue(url_appears_valid_url('lalala://@:@/'));
    }
}