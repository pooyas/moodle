<?php

/**
 * Course overview block caps.
 *
 * @package    block_course_overview
 * @copyright  Mark Nelson <markn@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'block/course_overview:myaddinstance' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'user' => CAP_ALLOW
        ),

        'clonepermissionsfrom' => 'lion/my:manageblocks'
    ),

    'block/course_overview:addinstance' => array(
        'riskbitmask' => RISK_SPAM | RISK_XSS,

        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => array(
            'manager' => CAP_ALLOW
        ),

        'clonepermissionsfrom' => 'lion/site:manageblocks'
    )
);
