<?php


/**
 * Standard log reader/writer cron task.
 *
 * @package    admin_tool
 * @subpackage log
 * @copyright  2015 Pooya Saeedi
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