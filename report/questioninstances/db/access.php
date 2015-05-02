<?php

/**
 * Capabilities
 *
 * @package    report_questioninstances
 * @copyright  2008 Tim Hunt
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'report/questioninstances:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'manager' => CAP_ALLOW
        ),

        'clonepermissionsfrom' => 'lion/site:config',
    )
);
