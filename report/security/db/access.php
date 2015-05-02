<?php

/**
 * Capabilities
 *
 * @package    report_security
 * @copyright  2008 Petr Skoda
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'report/security:view' => array(
        'riskbitmask' => RISK_CONFIG,
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'manager' => CAP_ALLOW
        ),
    )
);
