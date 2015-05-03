<?php

/**
 * My latest badges block capabilities.
 *
 * @package    block_badges
 * @copyright  2015 Pooya Saeedi
 * 
 * @author     Yuliya Bozhko <yuliya.bozhko@totaralms.com>
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