<?php

/**
 * Message providers list.
 *
 * @package    tool_monitor
 * @copyright  2014 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * 
 */

defined('LION_INTERNAL') || die();

$messageproviders = array (
    // Notify a user that a rule has happened.
    'notification' => array (
        'capability'  => 'tool/monitor:subscribe'
    )
);
