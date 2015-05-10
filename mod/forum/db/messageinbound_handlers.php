<?php

/**
 * Message Inbound Handlers for mod_forum.
 *
 * @package    mod
 * @subpackage forum
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$handlers = array(
    array(
        'classname' => '\mod_forum\message\inbound\reply_handler',
    ),
);
