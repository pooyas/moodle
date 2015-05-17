<?php


/**
 * This file contains the unittests for adhock tasks.
 *
 * @category  phpunit
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();
require_once(__DIR__ . '/fixtures/task_fixtures.php');


/**
 * Test class for adhoc tasks.
 *
 * @category task
 */
class core_adhoc_task_testcase extends advanced_testcase {

    public function test_get_next_adhoc_task() {
        $this->resetAfterTest(true);
        // Create an adhoc task.
        $task = new \core\task\adhoc_test_task();

        // Queue it.
        $task = \core\task\manager::queue_adhoc_task($task);

        $now = time();
        // Get it from the scheduler.
        $task = \core\task\manager::get_next_adhoc_task($now);
        $this->assertNotNull($task);
        $task->execute();

        \core\task\manager::adhoc_task_failed($task);
        // Should not get any task.
        $task = \core\task\manager::get_next_adhoc_task($now);
        $this->assertNull($task);

        // Should get the adhoc task (retry after delay).
        $task = \core\task\manager::get_next_adhoc_task($now + 120);
        $this->assertNotNull($task);
        $task->execute();

        \core\task\manager::adhoc_task_complete($task);

        // Should not get any task.
        $task = \core\task\manager::get_next_adhoc_task($now);
        $this->assertNull($task);
    }
}
