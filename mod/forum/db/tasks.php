<?php


/**
 * Definition of Forum scheduled tasks.
 *
 * @category  task
 * @package    mod
 * @subpackage forum
 * @copyright  2015 Pooya Saeedi
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
