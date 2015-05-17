<?php



/**
 * Defines the capabilities used by the Language customization admin tool
 *
 * @package    admin_tool
 * @subpackage customlang
 * @copyright  2015 Pooya Saeedi
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
