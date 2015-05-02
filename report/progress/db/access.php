<?php

/**
 * Capabilities
 *
 * @package    report_progress
 * @copyright  2008 Sam Marshall
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'report/progress:view' => array(
        'riskbitmask' => RISK_PERSONAL,
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),

        'clonepermissionsfrom' => 'coursereport/progress:view',
    )
);


