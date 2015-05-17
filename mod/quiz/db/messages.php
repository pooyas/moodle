<?php


/**
 * Defines message providers (types of message sent) for the quiz module.
 *
 * @package    mod
 * @subpackage quiz
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$messageproviders = array(
    // Notify teacher that a student has submitted a quiz attempt.
    'submission' => array(
        'capability' => 'mod/quiz:emailnotifysubmission'
    ),

    // Confirm a student's quiz attempt.
    'confirmation' => array(
        'capability' => 'mod/quiz:emailconfirmsubmission'
    ),

    // Warning to the student that their quiz attempt is now overdue, if the quiz
    // has a grace period.
    'attempt_overdue' => array(
        'capability' => 'mod/quiz:emailwarnoverdue'
    ),
);
