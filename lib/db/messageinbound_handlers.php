<?php

/**
 * Inbound Message Handlers for core.
 *
 * @package    core_message
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$handlers = array(
    array(
        'classname' => '\core\message\inbound\private_files_handler',
        'defaultexpiration' => 0,
    ),
);
