<?php

/**
 * Defines capabilities for the user report
 *
 * @package   gradereport_user
 * @copyright 2007 onwards Martin Dougiamas (http://dougiamas.com)
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'gradereport/user:view' => array(
        'riskbitmask' => RISK_PERSONAL,
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'student' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    ),
);


