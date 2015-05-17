<?php


/**
 * Social activities block caps.
 *
 * @package    blocks
 * @subpackage social_activities
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'block/social_activities:addinstance' => array(
        'riskbitmask' => RISK_SPAM | RISK_XSS,

        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),

        'clonepermissionsfrom' => 'lion/site:manageblocks'
    ),
);
