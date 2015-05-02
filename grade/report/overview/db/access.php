<?php

/**
 * Defines capabilities for the overview report
 *
 * @package   gradereport_overview
 * @copyright 2007 Nicolas Connault
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'gradereport/overview:view' => array(
        'riskbitmask' => RISK_PERSONAL,
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'student' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    )

);


