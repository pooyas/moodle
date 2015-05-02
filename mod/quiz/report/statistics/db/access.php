<?php

/**
 * Capability definitions for the quiz statistics report.
 *
 * @package   quiz_statistics
 * @copyright 2008 Jamie Pratt
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(
    'quiz/statistics:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),
        'clonepermissionsfrom' =>  'mod/quiz:viewreports'
    )
);
