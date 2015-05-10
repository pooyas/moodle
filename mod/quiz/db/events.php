<?php

/**
 * Add event handlers for the quiz
 *
 * @package    mod
 * @subpackage quiz
 * @category   event
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

$observers = array(

    // Handle group events, so that open quiz attempts with group overrides get updated check times.
    array(
        'eventname' => '\core\event\course_reset_started',
        'callback' => '\mod_quiz\group_observers::course_reset_started',
    ),
    array(
        'eventname' => '\core\event\course_reset_ended',
        'callback' => '\mod_quiz\group_observers::course_reset_ended',
    ),
    array(
        'eventname' => '\core\event\group_deleted',
        'callback' => '\mod_quiz\group_observers::group_deleted'
    ),
    array(
        'eventname' => '\core\event\group_member_added',
        'callback' => '\mod_quiz\group_observers::group_member_added',
    ),
    array(
        'eventname' => '\core\event\group_member_removed',
        'callback' => '\mod_quiz\group_observers::group_member_removed',
    ),

    // Handle our own \mod_quiz\event\attempt_submitted event, as a way to
    // send confirmation messages asynchronously.
    array(
        'eventname' => '\mod_quiz\event\attempt_submitted',
        'includefile'     => '/mod/quiz/locallib.php',
        'callback' => 'quiz_attempt_submitted_handler',
        'internal' => false
    ),
);
