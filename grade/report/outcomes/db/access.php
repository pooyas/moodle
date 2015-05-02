<?php

/**
 * Defines capabilities for the outcomes report
 *
 * @package   gradereport_outcomes
 * @copyright 2007 Petr Skoda
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'gradereport/outcomes:view' => array(
        'riskbitmask' => RISK_PERSONAL,
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    )

);


