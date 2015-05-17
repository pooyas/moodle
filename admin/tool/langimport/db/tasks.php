<?php


/**
 * Definition of langimport tasks
 *
 * @category  task
 * @package    admin_tool
 * @subpackage langimport
 * @copyright  2015 Pooya Saeedi
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
