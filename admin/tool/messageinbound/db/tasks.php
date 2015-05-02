<?php

/**
 * The Main Manager tasks.
 *
 * @package    tool_messageinbound
 * @copyright  2014 Andrew Nicols
 * 
 */

defined('LION_INTERNAL') || die();

$tasks = array(
    array(
        'classname' => '\tool_messageinbound\task\pickup_task',
        'blocking' => 0,
        'minute' => '*',
        'hour' => '*',
        'day' => '*',
        'dayofweek' => '*',
        'month' => '*'
    ),

    array(
        'classname' => '\tool_messageinbound\task\cleanup_task',
        'blocking' => 0,
        'minute' => '55',
        'hour' => '1',
        'day' => '*',
        'dayofweek' => '*',
        'month' => '*'
    ),
);
