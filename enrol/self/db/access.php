<?php


/**
 * Capabilities for self enrolment plugin.
 *
 * @package    enrol
 * @subpackage self
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    /* Add or edit enrol-self instance in course. */
    'enrol/self:config' => array(

        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
        )
    ),

    /* Manage user self-enrolments. */
    'enrol/self:manage' => array(

        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
        )
    ),

    'enrol/self:holdkey' => array(

        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'manager' => CAP_PROHIBIT,
        )
    ),

    /* Voluntarily unenrol self from course - watch out for data loss. */
    'enrol/self:unenrolself' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'student' => CAP_ALLOW,
        )
    ),

    /* Unenrol anybody from course (including self) -  watch out for data loss. */
    'enrol/self:unenrol' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
        )
    ),

);
