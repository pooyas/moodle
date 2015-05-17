<?php


/**
 * Capabilities
 *
 * @package    report
 * @subpackage performance
 * @copyright  2015 Pooya Saeedi
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
