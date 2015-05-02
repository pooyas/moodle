<?php


/**
 * Defines the capabilities used by the Language customization admin tool
 *
 * @package    tool_customlang
 * @copyright  2010 David Mudrak <david@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    /* allows the user to view the current language customization */
    'tool/customlang:view' => array(
        'riskbitmask' => RISK_CONFIG,
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'manager' => CAP_ALLOW
        ),
    ),

    /* allows the user to edit the current language customization */
    'tool/customlang:edit' => array(
        'riskbitmask' => RISK_CONFIG | RISK_XSS,
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'manager' => CAP_ALLOW
        ),
    ),

);
