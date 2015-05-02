<?php

/**
 * Capabilities
 *
 * @package   report_performance
 * @copyright 2013 Rajesh Taneja
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(
    'report/performance:view' => array(
        'riskbitmask' => RISK_CONFIG,
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'manager' => CAP_ALLOW
        ),
    )
);
