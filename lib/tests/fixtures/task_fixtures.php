<?php


/**
 * Fixtures for task tests.
 *
 * @category   phpunit
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\task;
defined('LION_INTERNAL') || die();

class adhoc_test_task extends \core\task\adhoc_task {
    public function execute() {
    }
}

class scheduled_test_task extends \core\task\scheduled_task {
    public function get_name() {
        return "Test task";
    }

    public function execute() {
    }
}

class scheduled_test2_task extends \core\task\scheduled_task {
    public function get_name() {
        return "Test task 2";
    }

    public function execute() {
    }
}

class scheduled_test3_task extends \core\task\scheduled_task {
    public function get_name() {
        return "Test task 3";
    }

    public function execute() {
    }
}
