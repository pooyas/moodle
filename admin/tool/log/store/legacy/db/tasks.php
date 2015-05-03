<?php

/**
 * Legacy log reader cron task.
 *
 * @package    tool
 * @subpackage log
 * @copyright  2015 Pooya Saeedi 
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