<?php

/**
 * Tests for report log live events.
 *
 * @package    report_loglive
 * @copyright  2014 Rajesh Taneja <rajesh@lion.com>
 * .
 */

defined('LION_INTERNAL') || die();

/**
 * Class report_loglive_events_testcase
 *
 * Class for tests related to log live events.
 *
 * @package    report_loglive
 * @copyright  2014 Rajesh Taneja <rajesh@lion.com>
 * .
 */
class report_loglive_events_testcase extends advanced_testcase {

    /**
     * Setup testcase.
     */
    public function setUp() {
        $this->setAdminUser();
        $this->resetAfterTest();
    }

    /**
     * Test the report viewed event.
     *
     * It's not possible to use the lion API to simulate the viewing of log report, so here we
     * simply create the event and trigger it.
     */
    public function test_report_viewed() {
        $course = $this->getDataGenerator()->create_course();
        $context = context_course::instance($course->id);
        // Trigger event for loglive report viewed.
        $event = \report_loglive\event\report_viewed::create(array('context' => $context));

        // Trigger and capture the event.
        $sink = $this->redirectEvents();
        $event->trigger();
        $events = $sink->get_events();
        $event = reset($events);

        $this->assertInstanceOf('\report_loglive\event\report_viewed', $event);
        $this->assertEquals($context, $event->get_context());
        $expected = array($course->id, 'course', 'report live', "report/loglive/index.php?id=$course->id", $course->id);
        $this->assertEventLegacyLogData($expected, $event);
        $this->assertEventContextNotUsed($event);
        $url = new lion_url('/report/loglive/index.php', array('id' => $course->id));
        $this->assertEquals($url, $event->get_url());
    }
}
