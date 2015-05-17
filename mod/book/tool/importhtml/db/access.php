<?php


/**
 * Book import capability definition
 *
 * @package    mod
 * @subpackage book
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

$capabilities = array(
    'booktool/importhtml:import' => array(
        'riskbitmask' => RISK_XSS,
        'captype' => 'write',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
        )
    ),
);
