<?php

/**
 * Unit tests for user/editlib.php.
 *
 * @package    core_user
 * @category   phpunit
 * @copyright  2013 Adrian Greeve <adrian@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot.'/user/editlib.php');

/**
 * Unit tests for user editlib api.
 *
 * @package    core_user
 * @category   phpunit
 * @copyright  2013 Adrian Greeve <adrian@lion.com>
 * 
 */
class core_user_editlib_testcase extends advanced_testcase {

    /**
     * Test that the required fields are returned in the correct order.
     */
    function test_useredit_get_required_name_fields() {
        global $CFG;
        // Back up config settings for restore later.
        $originalcfg = new stdClass();
        $originalcfg->fullnamedisplay = $CFG->fullnamedisplay;

        $CFG->fullnamedisplay = 'language';
        $expectedresult = array(5 => 'firstname', 21 => 'lastname');
        $this->assertEquals(useredit_get_required_name_fields(), $expectedresult);
        $CFG->fullnamedisplay = 'firstname';
        $expectedresult = array(5 => 'firstname', 21 => 'lastname');
        $this->assertEquals(useredit_get_required_name_fields(), $expectedresult);
        $CFG->fullnamedisplay = 'lastname firstname';
        $expectedresult = array('lastname', 9 => 'firstname');
        $this->assertEquals(useredit_get_required_name_fields(), $expectedresult);
        $CFG->fullnamedisplay = 'firstnamephonetic lastnamephonetic';
        $expectedresult = array(5 => 'firstname', 21 => 'lastname');
        $this->assertEquals(useredit_get_required_name_fields(), $expectedresult);

        // Tidy up after we finish testing.
        $CFG->fullnamedisplay = $originalcfg->fullnamedisplay;
    }

    /**
     * Test that the enabled fields are returned in the correct order.
     */
    function test_useredit_get_enabled_name_fields() {
        global $CFG;
        // Back up config settings for restore later.
        $originalcfg = new stdClass();
        $originalcfg->fullnamedisplay = $CFG->fullnamedisplay;

        $CFG->fullnamedisplay = 'language';
        $expectedresult = array();
        $this->assertEquals(useredit_get_enabled_name_fields(), $expectedresult);
        $CFG->fullnamedisplay = 'firstname lastname firstnamephonetic';
        $expectedresult = array(19 => 'firstnamephonetic');
        $this->assertEquals(useredit_get_enabled_name_fields(), $expectedresult);
        $CFG->fullnamedisplay = 'firstnamephonetic, lastname lastnamephonetic (alternatename)';
        $expectedresult = array('firstnamephonetic', 28 => 'lastnamephonetic', 46 => 'alternatename');
        $this->assertEquals(useredit_get_enabled_name_fields(), $expectedresult);
        $CFG->fullnamedisplay = 'firstnamephonetic lastnamephonetic alternatename middlename';
        $expectedresult = array('firstnamephonetic', 18 => 'lastnamephonetic', 35 => 'alternatename', 49 => 'middlename');
        $this->assertEquals(useredit_get_enabled_name_fields(), $expectedresult);

        // Tidy up after we finish testing.
        $CFG->fullnamedisplay = $originalcfg->fullnamedisplay;
    }

    /**
     * Test that the disabled fields are returned.
     */
    function test_useredit_get_disabled_name_fields() {
        global $CFG;
        // Back up config settings for restore later.
        $originalcfg = new stdClass();
        $originalcfg->fullnamedisplay = $CFG->fullnamedisplay;

        $CFG->fullnamedisplay = 'language';
        $expectedresult = array('firstnamephonetic' => 'firstnamephonetic', 'lastnamephonetic' => 'lastnamephonetic',
                'middlename' => 'middlename', 'alternatename' => 'alternatename');
        $this->assertEquals(useredit_get_disabled_name_fields(), $expectedresult);
        $CFG->fullnamedisplay = 'firstname lastname firstnamephonetic';
        $expectedresult = array('lastnamephonetic' => 'lastnamephonetic', 'middlename' => 'middlename', 'alternatename' => 'alternatename');
        $this->assertEquals(useredit_get_disabled_name_fields(), $expectedresult);
        $CFG->fullnamedisplay = 'firstnamephonetic, lastname lastnamephonetic (alternatename)';
        $expectedresult = array('middlename' => 'middlename');
        $this->assertEquals(useredit_get_disabled_name_fields(), $expectedresult);
        $CFG->fullnamedisplay = 'firstnamephonetic lastnamephonetic alternatename middlename';
        $expectedresult = array();
        $this->assertEquals(useredit_get_disabled_name_fields(), $expectedresult);

        // Tidy up after we finish testing.
        $CFG->fullnamedisplay = $originalcfg->fullnamedisplay;
    }
}
