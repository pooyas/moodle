<?php


/**
 * Handlers for tool_messageinbound.
 *
 * @package    admin_tool
 * @subpackage messageinbound
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$handlers = array(
    array(
        'classname'         => '\tool_messageinbound\message\inbound\invalid_recipient_handler',
        'enabled'           => true,
        'validateaddress'   => false,
    ),
);
