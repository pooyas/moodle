<?php


/**
 * Blog tags block caps.
 *
 * @package    blocks
 * @subpackage blog_tags
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'block/blog_tags:addinstance' => array(
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
