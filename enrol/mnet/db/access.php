<?php

/**
 * Capabilities for mnet enrolment plugin.
 *
 * @package    enrol_mnet
 * @copyright  2014 Daniel Neis Araujo
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(
    'enrol/mnet:config' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'manager' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
        )
    ),
);
