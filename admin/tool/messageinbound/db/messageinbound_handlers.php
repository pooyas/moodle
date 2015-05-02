<?php

/**
 * Handlers for tool_messageinbound.
 *
 * @package    tool_messageinbound
 * @copyright  2014 Andrew Nicols
 * 
 */

defined('LION_INTERNAL') || die();

$handlers = array(
    array(
        'classname'         => '\tool_messageinbound\message\inbound\invalid_recipient_handler',
        'enabled'           => true,
        'validateaddress'   => false,
    ),
);
