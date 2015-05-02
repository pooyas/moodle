<?php

/**
 * Definition of langimport tasks
 *
 * @package   tool_langimport
 * @category  task
 * @copyright 2014 Dan Poltawski <dan@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

$tasks = array(
    array(
        'classname' => 'tool_langimport\task\update_langpacks_task',
        'blocking' => 0,
        'minute' => 'R',
        'hour' => '4',
        'day' => '*',
        'month' => '*',
        'dayofweek' => '*'
    )
);
