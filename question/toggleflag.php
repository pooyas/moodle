<?php

/**
 * Used by ajax calls to toggle the flagged state of a question in an attempt.
 *
 * @package    core
 * @subpackage questionengine
 * @copyright  2009 The Open University
 * 
 */


define('AJAX_SCRIPT', true);

require_once('../config.php');
require_once($CFG->dirroot . '/question/engine/lib.php');

// Parameters
$qaid = required_param('qaid', PARAM_INT);
$qubaid = required_param('qubaid', PARAM_INT);
$questionid = required_param('qid', PARAM_INT);
$slot = required_param('slot', PARAM_INT);
$newstate = required_param('newstate', PARAM_BOOL);
$checksum = required_param('checksum', PARAM_ALPHANUM);

// Check user is logged in.
require_login();
require_sesskey();

// Check that the requested session really exists
question_flags::update_flag($qubaid, $questionid, $qaid, $slot, $checksum, $newstate);

echo 'OK';
