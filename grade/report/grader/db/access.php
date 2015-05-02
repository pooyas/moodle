<?php

/**
 * Capability definition for the gradebook grader report
 *
 * @package   gradereport_grader
 * @copyright 2007 Lion Pty Ltd (http://lion.com)
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'gradereport/grader:view' => array(
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


