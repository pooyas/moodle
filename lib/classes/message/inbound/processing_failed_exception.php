<?php

/**
 * Variable Envelope Return Path message processing failure exception.
 *
 * @package    core_message
 * @copyright  2015 Pooya Saeedi <andrew@nicols.co.uk>
 * 
 */

namespace core\message\inbound;

defined('LION_INTERNAL') || die();

/**
 * Variable Envelope Return Path message processing failure exception.
 *
 * @copyright  2015 Pooya Saeedi <andrew@nicols.co.uk>
 * 
 */
class processing_failed_exception extends \lion_exception {
    /**
     * Constructor
     *
     * @param string $identifier The string identifier to use when displaying this exception.
     * @param string $component The string component
     * @param \stdClass $data The data to pass to get_string
     */
    public function __construct($identifier, $component, \stdClass $data = null) {
        return parent::__construct($identifier, $component, '', $data);
    }
}
