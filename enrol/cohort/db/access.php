<?php

/**
 * Capabilities for cohort access plugin.
 *
 * @package    enrol_cohort
 * @copyright  2010 Petr Skoda {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'enrol/cohort:config' => array(

        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
        )
    ),

    /* This is used only when sync suspends users instead of full unenrolment. */
    'enrol/cohort:unenrol' => array(

        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'manager' => CAP_ALLOW,
        )
    ),

);
