<?php

/**
 * Capabilities gradeexport plugin.
 *
 * @package    gradeexport_xls
 * @copyright  2007 Petr Skoda {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'gradeexport/xls:view' => array(
        'riskbitmask' => RISK_PERSONAL,
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    ),

    'gradeexport/xls:publish' => array(
        'riskbitmask' => RISK_PERSONAL,
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'manager' => CAP_ALLOW
        )
    )

);


