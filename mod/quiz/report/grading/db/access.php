<?php

/**
 * Capability definitions for the quiz manual grading report.
 *
 * @package   quiz_grading
 * @copyright 2010 The Open University
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(
    // Is the user allowed to see the student's real names while grading?
    'quiz/grading:viewstudentnames' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'legacy' => array(
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW
        ),
        'clonepermissionsfrom' =>  'mod/quiz:viewreports'
    ),

    // Is the user allowed to see the student's idnumber while grading?
    'quiz/grading:viewidnumber' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'legacy' => array(
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW
        ),
        'clonepermissionsfrom' =>  'mod/quiz:viewreports'
    )
);
