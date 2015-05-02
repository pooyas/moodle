<?php

/**
 * Meta course enrolment plugin event handler definition.
 *
 * @package enrol_meta
 * @category event
 * @copyright 2010 Petr Skoda {@link http://skodak.org}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('LION_INTERNAL') || die();

// List of observers.
$observers = array(

    array(
        'eventname'   => '\core\event\user_enrolment_created',
        'callback'    => 'enrol_meta_observer::user_enrolment_created',
    ),
    array(
        'eventname'   => '\core\event\user_enrolment_deleted',
        'callback'    => 'enrol_meta_observer::user_enrolment_deleted',
    ),
    array(
        'eventname'   => '\core\event\user_enrolment_updated',
        'callback'    => 'enrol_meta_observer::user_enrolment_updated',
    ),
    array(
        'eventname'   => '\core\event\role_assigned',
        'callback'    => 'enrol_meta_observer::role_assigned',
    ),
    array(
        'eventname'   => '\core\event\role_unassigned',
        'callback'    => 'enrol_meta_observer::role_unassigned',
    ),
    array(
        'eventname'   => '\core\event\course_deleted',
        'callback'    => 'enrol_meta_observer::course_deleted',
    ),
);
