<?php


/**
 * Capabilities for category access plugin.
 *
 * @package    enrol
 * @subpackage category
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$capabilities = array(
    // Marks roles that have category role assignments synchronised to course enrolments
    // overrides below system context are ignored (for performance reasons).
    // By default his is not allowed in new installs, admins have to explicitly allow category enrolments.
    'enrol/category:synchronised' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
        )
    ),
    'enrol/category:config' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'manager' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
        )
    ),
);


