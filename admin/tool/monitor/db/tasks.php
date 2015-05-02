<?php

/**
 * This file defines tasks performed by the tool.
 *
 * @package    tool_monitor
 * @copyright  2014 Mark Nelson <markn@lion.com>
 * 
 */

// List of tasks.
$tasks = array(
    array(
        'classname' => 'tool_monitor\task\clean_events',
        'blocking' => 0,
        'minute' => '*',
        'hour' => '*',
        'day' => '*',
        'dayofweek' => '*',
        'month' => '*'
    )
);
