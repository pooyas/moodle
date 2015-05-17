<?php


/**
 * Capabilities for LDAP enrolment plugin.
 *
 * @package    enrol
 * @subpackage ldap
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$capabilities = array(
    'enrol/ldap:manage' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'manager' => CAP_ALLOW,
        )
    ),

);


