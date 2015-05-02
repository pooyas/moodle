<?php

/**
 * Forum event handler definition.
 *
 * @package mod_forum
 * @category event
 * @copyright 2010 Petr Skoda  {@link http://skodak.org}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// List of observers.
$observers = array(

    array(
        'eventname'   => '\core\event\user_enrolment_deleted',
        'callback'    => 'mod_forum_observer::user_enrolment_deleted',
    ),

    array(
        'eventname' => '\core\event\role_assigned',
        'callback' => 'mod_forum_observer::role_assigned'
    ),

    array(
        'eventname' => '\core\event\course_module_created',
        'callback'  => 'mod_forum_observer::course_module_created',
    ),
);
