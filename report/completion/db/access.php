<?php

/**
 * Capabilities
 *
 * @package    report_completion
 * @copyright  2009 Catalyst IT Ltd
 * @author     Aaron Barnes <aaronb@catalyst.net.nz>
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'report/completion:view' => array(
        'riskbitmask' => RISK_PERSONAL,
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),

        'clonepermissionsfrom' => 'coursereport/completion:view',
    )
);
