<?php


/**
 * Defines capabilities for the overview report
 *
 * @package    grade_report
 * @subpackage overview
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'gradereport/overview:view' => array(
        'riskbitmask' => RISK_PERSONAL,
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'student' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    )

);


