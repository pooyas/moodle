<?php

/**
 * Calendar lib unit tests
 *
 * @package    core_calendar
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();
global $CFG;
require_once($CFG->dirroot . '/calendar/lib.php');

/**
 * Unit tests for calendar lib
 *
 * @package    core_calendar
 * @copyright  2015 Pooya Saeedi
 * 
 */
class core_calendar_lib_testcase extends advanced_testcase {

    protected function setUp() {
        $this->resetAfterTest(true);
    }

    public function test_calendar_get_course_cached() {
        // Setup some test courses.
        $course1 = $this->getDataGenerator()->create_course();
        $course2 = $this->getDataGenerator()->create_course();
        $course3 = $this->getDataGenerator()->create_course();

        // Load courses into cache.
        $coursecache = null;
        calendar_get_course_cached($coursecache, $course1->id);
        calendar_get_course_cached($coursecache, $course2->id);
        calendar_get_course_cached($coursecache, $course3->id);

        // Verify the cache.
        $this->assertArrayHasKey($course1->id, $coursecache);
        $cachedcourse1 = $coursecache[$course1->id];
        $this->assertEquals($course1->id, $cachedcourse1->id);
        $this->assertEquals($course1->shortname, $cachedcourse1->shortname);
        $this->assertEquals($course1->fullname, $cachedcourse1->fullname);

        $this->assertArrayHasKey($course2->id, $coursecache);
        $cachedcourse2 = $coursecache[$course2->id];
        $this->assertEquals($course2->id, $cachedcourse2->id);
        $this->assertEquals($course2->shortname, $cachedcourse2->shortname);
        $this->assertEquals($course2->fullname, $cachedcourse2->fullname);

        $this->assertArrayHasKey($course3->id, $coursecache);
        $cachedcourse3 = $coursecache[$course3->id];
        $this->assertEquals($course3->id, $cachedcourse3->id);
        $this->assertEquals($course3->shortname, $cachedcourse3->shortname);
        $this->assertEquals($course3->fullname, $cachedcourse3->fullname);
    }

    /**
     * Test calendar cron with a working subscription URL.
     */
    public function test_calendar_cron_working_url() {
        global $CFG;
        require_once($CFG->dirroot . '/lib/cronlib.php');

        // Lion ICal URL (lion.org events).
        $presetwhat = 'all';
        $presettime = 'recentupcoming';
        $userid = 1;
        $authtoken = 'a8bcfee2fb868a05357f650bd65dc0699b026524';
        $subscriptionurl = 'https://lion.org/calendar/export_execute.php'
                . '?preset_what='.$presetwhat.'&preset_time='.$presettime.'&userid='.$userid.'&authtoken='.$authtoken;

        $subscription = new stdClass();
        $subscription->eventtype = 'site';
        $subscription->name = 'test';
        $subscription->url = $subscriptionurl;
        $subscription->pollinterval = 86400;
        $subscription->lastupdated = 0;
        calendar_add_subscription($subscription);

        $this->expectOutputRegex('/Events imported: .* Events updated:/');
        calendar_cron();
    }

    /**
     * Test calendar cron with a broken subscription URL.
     */
    public function test_calendar_cron_broken_url() {
        global $CFG;
        require_once($CFG->dirroot . '/lib/cronlib.php');

        $subscription = new stdClass();
        $subscription->eventtype = 'site';
        $subscription->name = 'test';
        $subscription->url = 'brokenurl';
        $subscription->pollinterval = 86400;
        $subscription->lastupdated = 0;
        calendar_add_subscription($subscription);

        $this->expectOutputRegex('/Error updating calendar subscription: The given iCal URL is invalid/');
        calendar_cron();
    }
}
