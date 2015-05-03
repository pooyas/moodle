<?php

/**
 * This file defines tasks performed by the tool.
 *
 * @package    tool
 * @subpackage monitor
 * @copyright  2015 Pooya Saeedi 
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
