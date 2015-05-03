<?php

/**
 * Fixtures for Inbound Message tests.
 *
 * @package    core_message
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\test;
defined('LION_INTERNAL') || die();

/**
 * A base handler for unit testing.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class handler_base extends \core\message\inbound\handler {
    /**
     * Get the description for unit tests.
     */
    public function get_description() {
    }

    /**
     * Get the name for unit tests.
     */
    public function get_name() {
    }

    /**
     * Process a message for unit tests.
     *
     * @param stdClass $record The record to process
     * @param stdClass $messagedata The message data
     */
    public function process_message(\stdClass $record, \stdClass $messagedata) {
    }
}

/**
 * A handler for unit testing.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class handler_one extends handler_base {
}

/**
 * A handler for unit testing.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class handler_two extends handler_base {
}

/**
 * A handler for unit testing.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class handler_three extends handler_base {
}

/**
 * A handler for unit testing.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class handler_four extends handler_base {
}
