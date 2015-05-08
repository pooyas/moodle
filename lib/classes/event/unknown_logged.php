<?php

/**
 * Unknown event.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Unknown event class.
 *
 */
class unknown_logged extends base {
    public function init() {
        throw new \coding_exception('unknown events cannot be triggered');
    }

    public static function get_name() {
        return get_string('eventunknownlogged', 'core');
    }

    public function get_description() {
        return 'Unknown event (' . $this->eventname . ')';
    }
}
