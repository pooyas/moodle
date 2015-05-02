<?php

/**
 * Capabilities gradeimport plugin.
 *
 * @package    gradeimport_direct
 * @copyright  2014 Adrian Greeve <adrian@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'gradeimport/direct:view' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    )
);