<?php

/**
 * Inbound Message Handlers for core.
 *
 * @package    core_message
 * @copyright  2014 Andrew NIcols
 * 
 */

defined('LION_INTERNAL') || die();

$handlers = array(
    array(
        'classname' => '\core\message\inbound\private_files_handler',
        'defaultexpiration' => 0,
    ),
);
