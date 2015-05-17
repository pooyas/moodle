<?php


/**
 * Tests for base course module instance list viewed event.
 *
 * @category   phpunit
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();
require_once(__DIR__.'/fixtures/event_mod_fixtures.php');

/**
 * Class core_event_course_module_instance_list_viewed_testcase
 *
 * Tests for event \core\event\course_module_instance_list_viewed_testcase
 */
class core_event_course_module_instance_list_viewed_testcase extends advanced_testcase {

    /**
     * Test event properties and methods.
     */
    public function test_event_attributes() {

        $this->resetAfterTest();
        $course = $this->getDataGenerator()->create_course();
        $context = context_course::instance($course->id);

        // Trigger the page view event.
        $sink = $this->redirectEvents();
        $event = \mod_unittests\event\course_module_instance_list_viewed::create(array(
             'context' => $context,
        ));
        $event->trigger();
        $result = $sink->get_events();
        $event = reset($result);
        $sink->close();

        // Test event data.
        $legacydata = array($course->id, 'unittests', 'view all', 'index.php?id=' . $course->id, '');
        $this->assertEventLegacyLogData($legacydata, $event);
        $url = new lion_url('/mod/unittests/index.php', array('id' => $course->id));
        $this->assertEquals($url, $event->get_url());
        $this->assertEventContextNotUsed($event);

    }

    /**
     * Test custom validations of the event.
     */
    public function test_event_validations() {
        try {
            \mod_unittests\event\course_module_instance_list_viewed::create(array('context' => context_system::instance()));
            $this->fail('Event validation should not allow course_module_instance_list_viewed event to be triggered without outside
                    course context');
        } catch (Exception $e) {
            $this->assertInstanceOf('coding_exception', $e);
        }
    }
}
