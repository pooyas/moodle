<?php

/**
 * Message Inbound Handlers for mod_forum.
 *
 * @package    mod_forum
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$handlers = array(
    array(
        'classname' => '\mod_forum\message\inbound\reply_handler',
    ),
);
