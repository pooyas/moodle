<?php

/**
 * Inbound Message Handlers for core.
 *
 * @package    core
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
