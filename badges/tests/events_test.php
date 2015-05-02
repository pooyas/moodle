<?php
/**
 * Badge events tests.
 *
 * @package    core_badges
 * @copyright  2015 onwards Simey Lameze <simey@lion.com>
 * 
 */
defined('LION_INTERNAL') || die();
global $CFG;
require_once($CFG->dirroot . '/badges/tests/badgeslib_test.php');

/**
 * Badge events tests class.
 *
 * @package    core_badges
 * @copyright  2015 onwards Simey Lameze <simey@lion.com>
 * 
 */
class core_badges_events_testcase extends core_badges_badgeslib_testcase {

    /**
     * Test badge awarded event.
     */
    public function test_badge_awarded() {

        $systemcontext = context_system::instance();

        $sink = $this->redirectEvents();

        $badge = new badge($this->badgeid);
        $badge->issue($this->user->id, true);
        $badge->is_issued($this->user->id);
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = reset($events);
        $this->assertInstanceOf('\core\event\badge_awarded', $event);
        $this->assertEquals($this->badgeid, $event->objectid);
        $this->assertEquals($this->user->id, $event->relateduserid);
        $this->assertEquals($systemcontext, $event->get_context());

        $sink->close();
    }
}