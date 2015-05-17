<?php


/**
 * My latest badges block capabilities.
 *
 * @package    blocks
 * @subpackage badges
 * @copyright  2015 Pooya Saeedi
 */

$capabilities = array(
        'block/badges:addinstance' => array(
                'captype'      => 'read',
                'contextlevel' => CONTEXT_BLOCK,
                'archetypes' => array(
                    'editingteacher' => CAP_ALLOW,
                    'manager' => CAP_ALLOW
                ),
                'clonepermissionsfrom' => 'lion/site:manageblocks'
        ),
        'block/badges:myaddinstance' => array(
                'riskbitmask'  => RISK_PERSONAL,
                'captype'      => 'read',
                'contextlevel' => CONTEXT_SYSTEM,
                'archetypes'   => array(
                        'user' => CAP_ALLOW,
                ),
                'clonepermissionsfrom' => 'lion/my:manageblocks'
        ),
);