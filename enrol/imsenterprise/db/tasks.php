<?php

/**
 * Definition of IMS Enterprise enrolment scheduled tasks.
 *
 * @package    enrol
 * @subpackage imsenterprise
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$tasks = array(
    array(
        'classname' => 'enrol_imsenterprise\task\cron_task',
        'blocking' => 0,
        'minute' => '10',
        'hour' => '*',
        'day' => '*',
        'month' => '*',
        'dayofweek' => '*'
    )
);
