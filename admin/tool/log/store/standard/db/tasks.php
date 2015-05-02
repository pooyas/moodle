<?php

/**
 * Standard log reader/writer cron task.
 *
 * @package    logstore_standard
 * @copyright  2014 Petr Skoda {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die();

$tasks = array(
    array(
        'classname' => '\logstore_standard\task\cleanup_task',
        'blocking' => 0,
        'minute' => '*',
        'hour' => '4',
        'day' => '*',
        'dayofweek' => '*',
        'month' => '*'
    ),
);