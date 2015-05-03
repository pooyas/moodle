<?php

/**
 * Capabilities for manual enrolment plugin.
 *
 * @package    enrol_flatfile
 * @copyright  2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(
    /* Manage enrolments of users - requires allowmodifications enabled. */
    'enrol/flatfile:manage' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
        )
    ),

    /* Unenrol anybody (including self) - requires allowmodifications enabled */
    'enrol/flatfile:unenrol' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
        )
    ),
);
