<?php


/**
 * Capabilities gradeimport plugin.
 *
 * @package    grade_import
 * @subpackage csv
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'gradeimport/csv:view' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    )
);


