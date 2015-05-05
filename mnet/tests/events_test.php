<?php

/**
 * Events tests.
 *
 * @package   core_mnet
 * @category  test
 * @copyright 2013 2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/mnet/lib.php');

class mnet_events_testcase extends advanced_testcase {

    /** @var stdClass the mnet host we are using to test */
    protected $mnethost;

    /**
     * Test set up.
     *
     * This is executed before running any test in this file.
     */
    public function setUp() {
        global $DB;

        $this->resetAfterTest();

        // Add a mnet host.
        $this->mnethost = new stdClass();
        $this->mnethost->name = 'A mnet host';
        $this->mnethost->public_key = 'A random public key!';
        $this->mnethost->id = $DB->insert_record('mnet_host', $this->mnethost);
    }

    /**
     * Test the mnet access control created event.
     */
    public function test_mnet_access_control_created() {
        // Trigger and capture the event.
        $sink = $this->redirectEvents();
        mnet_update_sso_access_control('username', $this->mnethost->id, 'enabled');
        $events = $sink->get_events();
        $event = reset($events);

        // Check that the event data is valid.
        $this->assertInstanceOf('\core\event\mnet_access_control_created', $event);
        $this->assertEquals(context_system::instance(), $event->get_context());
        $expected = array(SITEID, 'admin/mnet', 'add', 'admin/mnet/access_control.php',
            'SSO ACL: enabled user \'username\' from ' . $this->mnethost->name);
        $this->assertEventLegacyLogData($expected, $event);
        $this->assertEventContextNotUsed($event);
        $url = new \lion_url('/admin/mnet/access_control.php');
        $this->assertEquals($url, $event->get_url());
    }

    /**
     * Test the mnet access control updated event.
     */
    public function test_mnet_access_control_updated() {
        global $DB;

        // Create a mnet access control.
        $mnetaccesscontrol = new stdClass();
        $mnetaccesscontrol->username = 'username';
        $mnetaccesscontrol->mnet_host_id = $this->mnethost->id;
        $mnetaccesscontrol->accessctrl = 'enabled';
        $mnetaccesscontrol->id = $DB->insert_record('mnet_sso_access_control', $mnetaccesscontrol);

        // Trigger and capture the event.
        $sink = $this->redirectEvents();
        mnet_update_sso_access_control('username', $this->mnethost->id, 'enabled');
        $events = $sink->get_events();
        $event = reset($events);

        // Check that the event data is valid.
        $this->assertInstanceOf('\core\event\mnet_access_control_updated', $event);
        $this->assertEquals(context_system::instance(), $event->get_context());
        $expected = array(SITEID, 'admin/mnet', 'update', 'admin/mnet/access_control.php',
            'SSO ACL: enabled user \'username\' from ' . $this->mnethost->name);
        $this->assertEventLegacyLogData($expected, $event);
        $this->assertEventContextNotUsed($event);
        $url = new \lion_url('/admin/mnet/access_control.php');
        $this->assertEquals($url, $event->get_url());
    }
}
