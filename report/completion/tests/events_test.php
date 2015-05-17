<?php


/**
 * Tests for report completion events.
 *
 * @package    report
 * @subpackage completion
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Class report_completion_events_testcase
 *
 * Class for tests related to completion report events.
 *
 */
class report_completion_events_testcase extends advanced_testcase {

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
        // Trigger event for completion report viewed.
        $event = \report_completion\event\report_viewed::create(array('context' => $context));

        // Trigger and capture the event.
        $sink = $this->redirectEvents();
        $event->trigger();
        $events = $sink->get_events();
        $event = reset($events);

        $this->assertInstanceOf('\report_completion\event\report_viewed', $event);
        $this->assertEquals($context, $event->get_context());
        $url = new lion_url('/report/completion/index.php', array('course' => $course->id));
        $this->assertEquals($url, $event->get_url());
        $this->assertEventContextNotUsed($event);
    }

    /**
     * Test the user report viewed event.
     *
     * It's not possible to use the lion API to simulate the viewing of log report, so here we
     * simply create the event and trigger it.
     */
    public function test_user_report_viewed() {
        $course = $this->getDataGenerator()->create_course();
        $context = context_course::instance($course->id);
        // Trigger event for completion report viewed.
        $event = \report_completion\event\user_report_viewed::create(array('context' => $context, 'relateduserid' => 3));

        // Trigger and capture the event.
        $sink = $this->redirectEvents();
        $event->trigger();
        $events = $sink->get_events();
        $event = reset($events);

        $this->assertInstanceOf('\report_completion\event\user_report_viewed', $event);
        $this->assertEquals($context, $event->get_context());
        $this->assertEquals(3, $event->relateduserid);
        $this->assertEquals(new lion_url('/report/completion/user.php', array('id' => 3, 'course' => $course->id)),
                $event->get_url());
        $expected = array($course->id, 'course', 'report completion', "report/completion/user.php?id=3&course=$course->id",
                $course->id);
        $this->assertEventLegacyLogData($expected, $event);
        $this->assertEventContextNotUsed($event);
    }
}
