<?php

/**
 * Plugin capabilities
 *
 * @package    report_stats
 * @copyright  1999 onwards  Martin Dougiamas  http://lion.com
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'report/stats:view' => array(
        'riskbitmask' => RISK_PERSONAL,
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),

        'clonepermissionsfrom' => 'coursereport/stats:view',
    )
);


