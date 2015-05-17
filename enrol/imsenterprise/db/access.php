<?php


/**
 * Capabilities for imsenterprise enrolment plugin.
 *
 * @package    enrol
 * @subpackage imsenterprise
 * @copyright  2015 Pooya Saeedi
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

