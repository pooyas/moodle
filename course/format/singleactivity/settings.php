<?php

/**
 * Settings for format_singleactivity
 *
 * @package    format_singleactivity
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;
require_once($CFG->dirroot. '/course/format/singleactivity/settingslib.php');

if ($ADMIN->fulltree) {
    $settings->add(new format_singleactivity_admin_setting_activitytype('format_singleactivity/activitytype',
            new lang_string('defactivitytype', 'format_singleactivity'),
            new lang_string('defactivitytypedesc', 'format_singleactivity'),
            'forum', null));
}
