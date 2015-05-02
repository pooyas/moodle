<?php

/**
 * Unknown event.
 *
 * @package    core
 * @since      Lion 2.7
 * @copyright  2014 Petr Skoda
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Unknown event class.
 *
 * @package    core
 * @since      Lion 2.7
 * @copyright  2014 Petr Skoda
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
