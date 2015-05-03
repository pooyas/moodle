<?php

/**
 * Defines site config settings for the grade history report
 *
 * @package    gradereport_history
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // Add settings for this module to the $settings object (it's already defined).
    $settings->add(new admin_setting_configtext('grade_report_historyperpage',
        new lang_string('historyperpage', 'gradereport_history'),
        new lang_string('historyperpage_help', 'gradereport_history'),
        50
    ));

}
