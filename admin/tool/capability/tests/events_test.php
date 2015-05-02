<?php

/**
 * Tests for capability overview events.
 *
 * @package    tool_capability
 * @copyright  2014 Petr Skoda
 * .
 */

defined('LION_INTERNAL') || die();

/**
 * Class for capability overview events.
 *
 * @package    tool_capability
 * @copyright  2014 Petr Skoda
 * .
 */
class tool_capability_events_testcase extends advanced_testcase {

    /**
     * Setup testcase.
     */
    public function setUp() {
        $this->setAdminUser();
        $this->resetAfterTest();
    }

    /**
     * Test the report viewed event.
     */
    public function test_report_viewed() {
        $event = \tool_capability\event\report_viewed::create();

        // Trigger and capture the event.
        $sink = $this->redirectEvents();
        $event->trigger();
        $events = $sink->get_events();
        $event = reset($events);

        $this->assertInstanceOf('\tool_capability\event\report_viewed', $event);
        $this->assertEquals(context_system::instance(), $event->get_context());
        $expected = array(SITEID, "admin", "tool capability", "tool/capability/index.php");
        $this->assertEventLegacyLogData($expected, $event);
        $this->assertEventContextNotUsed($event);
        $url = new lion_url('/admin/tool/capability/index.php');
        $this->assertEquals($url, $event->get_url());
        $event->get_name();
    }
}
