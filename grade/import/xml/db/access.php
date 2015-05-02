<?php

/**
 * Capabilities gradeimport plugin.
 *
 * @package    gradeimport_xml
 * @copyright  2007 Martin Dougiamas
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'gradeimport/xml:view' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    ),

    'gradeimport/xml:publish' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'manager' => CAP_ALLOW
        )
    )
);


