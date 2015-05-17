<?php


/**
 * Tests for base course module viewed event.
 *
 * @category   phpunit
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();
require_once(__DIR__.'/fixtures/event_fixtures.php');

/**
 * Class core_event_course_module_viewed_testcase
 *
 * Tests for event \core\event\course_module_viewed
 */
class core_event_course_module_viewed_testcase extends advanced_testcase {

    /**
     * Test event properties and methods.
     */
    public function test_event_attributes() {

        $this->resetAfterTest();
        $course = $this->getDataGenerator()->create_course();
        $record = new stdClass();
        $record->course = $course->id;
        $feed = $this->getDataGenerator()->create_module('feedback', $record);
        $cm = get_coursemodule_from_instance('feedback', $feed->id);
        $context = context_module::instance($cm->id);

        // Trigger the page view event.
        $sink = $this->redirectEvents();
        $pageevent = \core_tests\event\course_module_viewed::create(array(
            'context' => $context,
            'courseid' => $course->id,
            'objectid' => $feed->id
        ));
        $pageevent->trigger();
        $result = $sink->get_events();
        $event = reset($result);
        $sink->close();

        // Test event data.
        $legacydata = array($course->id, 'feedback', 'view', 'view.php?id=' . $cm->id, $feed->id, $cm->id);
        $this->assertEventLegacyLogData($legacydata, $event);
        $this->assertSame('feedback', $event->objecttable);
        $url = new lion_url('/mod/feedback/view.php', array('id' => $cm->id));
        $this->assertEquals($url, $event->get_url());
        $this->assertEventContextNotUsed($event);

    }

    /**
     * Test custom validations of the event.
     */
    public function test_event_validations() {

        // Make sure objecttable and object id is always set.
        try {
            \core_tests\event\course_module_viewed_noinit::create(array(
                'contextid' => 1,
                'courseid' => 2,
                'objectid' => 3 ));
        } catch (coding_exception $e) {
            $this->assertContains("course_module_viewed event must define objectid and object table.", $e->getMessage());
        }

        try {
            \core_tests\event\course_module_viewed::create(array(
                'contextid' => 1,
                'courseid' => 2,
            ));
        } catch (coding_exception $e) {
            $this->assertContains("course_module_viewed event must define objectid and object table.", $e->getMessage());
        }
    }
}
