<?php

/**
 * Capabilities for imsenterprise enrolment plugin.
 *
 * @package    enrol_imsenterprise
 * @copyright  2014 Daniel Neis Araujo
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(
    'enrol/imsenterprise:config' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'manager' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
        )
    ),
);

