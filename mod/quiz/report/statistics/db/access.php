<?php

/**
 * Capability definitions for the quiz statistics report.
 *
 * @package   quiz
 * @subpackage statistics
 * @copyright 2015 Pooya Saeedi
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
