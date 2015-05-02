<?php

/**
 * Blog menu block caps.
 *
 * @package    block_blog_menu
 * @copyright  Mark Nelson <markn@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'block/blog_menu:addinstance' => array(
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
