<?php

/**
 * Dummy storage manager, returns nothing.
 * used when no other manager available.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\log;

defined('LION_INTERNAL') || die();

class dummy_manager implements manager {
    public function get_readers($interface = null) {
        return array();
    }

    public function dispose() {
    }

    public function get_supported_logstores($component) {
        return array();
    }
}
