<?php

/**
 * Category enrolment plugin event handler definition.
 *
 * @package   enrol_category
 * @category  event
 * @copyright 2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$observers = array (

    array (
        'eventname' => '\core\event\role_assigned',
        'callback'  => 'enrol_category_observer::role_assigned',
    ),

    array (
        'eventname' => '\core\event\role_unassigned',
        'callback'  => 'enrol_category_observer::role_unassigned',
    ),

);
