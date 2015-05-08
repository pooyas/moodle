<?php

/**
 * Tests for stats report events.
 *
 * @package    report_stats
 * @copyright  2015 Pooya Saeedi
 * .
 */

defined('LION_INTERNAL') || die();

/**
 * Class report_stats_events_testcase
 *
 * Class for tests related to stats report events.
 *
 * @package    report_stats
 * @copyright  2015 Pooya Saeedi
 * .
 */
class report_stats_events_testcase extends advanced_testcase {

    /**
     * Setup testcase.
     */
    public function setUp() {
        $this->setAdminUser();
        $this->resetAfterTest();
    }

    /**
     * Test the stats report viewed event.
     *
     * It's not possible to use the lion API to simulate the viewing of stats report, so here we
     * simply create the event and trigger it.
     */
    public function test_report_viewed() {
        $user = $this->getDataGenerator()->create_user();
        $course = $this->getDataGenerator()->create_course();
        $context = context_course::instance($course->id);

        // Trigger event for stats report viewed.
        $event = \report_stats\event\report_viewed::create(array('context' => $context, 'relateduserid' => $user->id,
                'other' => array('report' => 0, 'time' => 0, 'mode' => 1)));

        // Trigger and capture the event.
        $sink = $this->redirectEvents();
        $event->trigger();
        $events = $sink->get_events();
        $event = reset($events);

        $this->assertInstanceOf('\report_stats\event\report_viewed', $event);
        $this->assertEquals($context, $event->get_context());
        $expected = array($course->id, "course", "report stats", "report/stats/index.php?course=$course->id", $course->id);
        $this->assertEventLegacyLogData($expected, $event);
        $this->assertEventContextNotUsed($event);
    }

    /**
     * Test the user stats report viewed event.
     *
     * It's not possible to use the lion API to simulate the viewing of user stats report, so here we
     * simply create the event and trigger it.
     */
    public function test_user_report_viewed() {
        $user = $this->getDataGenerator()->create_user();
        $course = $this->getDataGenerator()->create_course();
        $context = context_course::instance($course->id);

        // Trigger event for user stats report viewed.
        $event = \report_stats\event\user_report_viewed::create(array('context' => $context, 'relateduserid' => $user->id));

        // Trigger and capture the event.
        $sink = $this->redirectEvents();
        $event->trigger();
        $events = $sink->get_events();
        $event = reset($events);

        $this->assertInstanceOf('\report_stats\event\user_report_viewed', $event);
        $this->assertEquals($context, $event->get_context());
        $url = $url = 'report/stats/user.php?id=' . $user->id . '&course=' . $course->id;
        $expected = array($course->id, 'course', 'report stats', $url, $course->id);
        $this->assertEventLegacyLogData($expected, $event);
        $this->assertEventContextNotUsed($event);
    }
}
