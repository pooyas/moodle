<?php

/**
 * This file contains the capabilities used by the lti module
 *
 * @package    mod
 * @subpackage lti
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

$capabilities = array(

    // Whether the user can see the link to the external tool and follow it.
    'mod/lti:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'student' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    ),

    // Add an External tool activity to a course.
    'mod/lti:addinstance' => array(
        'riskbitmask' => RISK_XSS,

        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),
        'clonepermissionsfrom' => 'lion/course:manageactivities'
    ),

    // When the user arrives at the external tool, if they have this capability
    // in Lion, then they are given the Instructor role in the remote system,
    // otherwise they are given Learner. See the lti_get_ims_role function.
    'mod/lti:manage' => array(
        'riskbitmask' => RISK_PERSONAL, // A bit of a guess, but seems likely.

        'captype' => 'write',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    ),

    // The ability to create or edit tool configurations for particular courses.
    'mod/lti:addcoursetool' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    ),

    // The ability to request the administrator to configure a particular
    // External tool globally.
    'mod/lti:requesttooladd' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    )
);
