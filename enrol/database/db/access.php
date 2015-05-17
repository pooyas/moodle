<?php


/**
 * Capabilities for database enrolment plugin.
 *
 * @package    enrol
 * @subpackage database
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$capabilities = array(
    /* This is used only when sync suspends users instead of full unenrolment. */
    'enrol/database:unenrol' => array(

        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'manager' => CAP_ALLOW,
        )
    ),
    'enrol/database:config' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'manager' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
        )
    ),
);
