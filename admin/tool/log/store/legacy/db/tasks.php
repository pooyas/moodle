<?php

/**
 * Legacy log reader cron task.
 *
 * @package    logstore_legacy
 * @copyright  2014 Petr Skoda {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die();

$tasks = array(
    array(
        'classname' => '\logstore_legacy\task\cleanup_task',
        'blocking' => 0,
        'minute' => '*',
        'hour' => '5',
        'day' => '*',
        'dayofweek' => '*',
        'month' => '*'
    ),
);