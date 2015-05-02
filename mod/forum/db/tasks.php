<?php

/**
 * Definition of Forum scheduled tasks.
 *
 * @package   mod_forum
 * @category  task
 * @copyright 2014 Dan Poltawski <dan@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

$tasks = array(
    array(
        'classname' => 'mod_forum\task\cron_task',
        'blocking' => 0,
        'minute' => '*',
        'hour' => '*',
        'day' => '*',
        'month' => '*',
        'dayofweek' => '*'
    )
);
