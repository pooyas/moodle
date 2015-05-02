<?php

/**
 * Capabilities gradeimport plugin.
 *
 * @package    gradeimport_csv
 * @copyright  2007 Martin Dougiamas
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'gradeimport/csv:view' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    )
);


