<?php


/**
 * Calendar Ical unit tests
 *
 * @package    calendar
 * @subpackage tests
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

global $CFG;


/**
 * Unit tests for ical APIs.
 *
 */
class core_calendar_ical_testcase extends advanced_testcase {

    /**
     * Tests set up
     */
    protected function setUp() {
        global $CFG;
        require_once($CFG->dirroot . '/calendar/lib.php');
    }

    public function test_calendar_update_subscription() {
        $this->resetAfterTest(true);

        $subscription = new stdClass();
        $subscription->eventtype = 'site';
        $subscription->name = 'test';
        $id = calendar_add_subscription($subscription);

        $subscription = new stdClass();
        $subscription->id = $id;
        $subscription->name = 'awesome';
        calendar_update_subscription($subscription);
        $sub = calendar_get_subscription($id);
        $this->assertEquals($subscription->name, $sub->name);

        $subscription = new stdClass();
        $subscription->id = $id;
        $subscription->name = 'awesome2';
        $subscription->pollinterval = 604800;
        calendar_update_subscription($subscription);
        $sub = calendar_get_subscription($id);
        $this->assertEquals($subscription->name, $sub->name);
        $this->assertEquals($subscription->pollinterval, $sub->pollinterval);

        $subscription = new stdClass();
        $subscription->name = 'awesome4';
        $this->setExpectedException('coding_exception');
        calendar_update_subscription($subscription);
    }

    public function test_calendar_add_subscription() {
        global $DB, $CFG;

        require_once($CFG->dirroot . '/lib/bennu/bennu.inc.php');

        $this->resetAfterTest(true);

        // Test for Microsoft Outlook 2010.
        $subscription = new stdClass();
        $subscription->name = 'Microsoft Outlook 2010';
        $subscription->importfrom = CALENDAR_IMPORT_FROM_FILE;
        $subscription->eventtype = 'site';
        $id = calendar_add_subscription($subscription);

        $calendar = file_get_contents($CFG->dirroot . '/lib/tests/fixtures/ms_outlook_2010.ics');
        $ical = new iCalendar();
        $ical->unserialize($calendar);
        $this->assertEquals($ical->parser_errors, array());

        $sub = calendar_get_subscription($id);
        $result = calendar_import_icalendar_events($ical, $sub->courseid, $sub->id);
        $count = $DB->count_records('event', array('subscriptionid' => $sub->id));
        $this->assertEquals($count, 1);

        // Test for OSX Yosemite.
        $subscription = new stdClass();
        $subscription->name = 'OSX Yosemite';
        $subscription->importfrom = CALENDAR_IMPORT_FROM_FILE;
        $subscription->eventtype = 'site';
        $id = calendar_add_subscription($subscription);

        $calendar = file_get_contents($CFG->dirroot . '/lib/tests/fixtures/osx_yosemite.ics');
        $ical = new iCalendar();
        $ical->unserialize($calendar);
        $this->assertEquals($ical->parser_errors, array());

        $sub = calendar_get_subscription($id);
        $result = calendar_import_icalendar_events($ical, $sub->courseid, $sub->id);
        $count = $DB->count_records('event', array('subscriptionid' => $sub->id));
        $this->assertEquals($count, 1);

        // Test for Google Gmail.
        $subscription = new stdClass();
        $subscription->name = 'Google Gmail';
        $subscription->importfrom = CALENDAR_IMPORT_FROM_FILE;
        $subscription->eventtype = 'site';
        $id = calendar_add_subscription($subscription);

        $calendar = file_get_contents($CFG->dirroot . '/lib/tests/fixtures/google_gmail.ics');
        $ical = new iCalendar();
        $ical->unserialize($calendar);
        $this->assertEquals($ical->parser_errors, array());

        $sub = calendar_get_subscription($id);
        $result = calendar_import_icalendar_events($ical, $sub->courseid, $sub->id);
        $count = $DB->count_records('event', array('subscriptionid' => $sub->id));
        $this->assertEquals($count, 1);
    }
}
