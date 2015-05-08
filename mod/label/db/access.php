<?php

/**
 * Capability definitions for the label module.
 *
 * @package    mod_label
 * @copyright  2015 Pooya Saeedi
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or late
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'mod/label:addinstance' => array(
        'riskbitmask' => RISK_XSS,

        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),
        'clonepermissionsfrom' => 'lion/course:manageactivities'
    ),

);
