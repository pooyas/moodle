<?php


/**
 * Tests for deprecated events. Please add tests for deprecated events in this file.
 *
 * @category   phpunit
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Class core_event_instances_list_viewed_testcase
 *
 * Tests for deprecated events.
 */
class core_event_deprecated_testcase extends advanced_testcase {

    /**
     * Test event properties and methods.
     */
    public function test_deprecated_course_module_instances_list_viewed_events() {

        // Make sure the abstract class course_module_instances_list_viewed generates a debugging notice.
        require_once(__DIR__.'/fixtures/event_mod_badfixtures.php');
        $this->assertDebuggingCalled(null, DEBUG_DEVELOPER);

    }
}
