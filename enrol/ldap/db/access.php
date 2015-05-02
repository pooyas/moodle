<?php

/**
 * Capabilities for LDAP enrolment plugin.
 *
 * @package    enrol_ldap
 * @author     Iñaki Arenaza
 * @copyright  2010 Iñaki Arenaza <iarenaza@eps.mondragon.edu>
 * 
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


