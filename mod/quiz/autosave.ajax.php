<?php

/**
 * Thisscript processes ajax auto-save requests during the quiz.
 *
 * @package    mod_quiz
 * @copyright  2013 The Open University
 * 
 */

define('AJAX_SCRIPT', true);

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');

// Remember the current time as the time any responses were submitted
// (so as to make sure students don't get penalized for slow processing on this page).
$timenow = time();
require_sesskey();

// Get submitted parameters.
$attemptid = required_param('attempt',  PARAM_INT);
$thispage  = optional_param('thispage', 0, PARAM_INT);

$transaction = $DB->start_delegated_transaction();
$attemptobj = quiz_attempt::create($attemptid);

// Check login.
require_login($attemptobj->get_course(), false, $attemptobj->get_cm());

// Check that this attempt belongs to this user.
if ($attemptobj->get_userid() != $USER->id) {
    throw new lion_quiz_exception($attemptobj->get_quizobj(), 'notyourattempt');
}

// Check capabilities.
if (!$attemptobj->is_preview_user()) {
    $attemptobj->require_capability('mod/quiz:attempt');
}

// If the attempt is already closed, send them to the review page.
if ($attemptobj->is_finished()) {
    throw new lion_quiz_exception($attemptobj->get_quizobj(),
            'attemptalreadyclosed', null, $attemptobj->review_url());
}

$attemptobj->process_auto_save($timenow);
$transaction->allow_commit();
echo 'OK';
