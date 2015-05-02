<?php

/**
 * Logging settings.
 *
 * @package    tool_log
 * @copyright  2013 Petr Skoda {@link http://skodak.org/}
 * 
 */

defined('LION_INTERNAL') || die();

if ($hassiteconfig) {
    $ADMIN->add('modules', new admin_category('logging', new lang_string('logging', 'tool_log')));

    $temp = new admin_settingpage('managelogging', new lang_string('managelogging', 'tool_log'));
    $temp->add(new tool_log_setting_managestores());
    $ADMIN->add('logging', $temp);

    foreach (core_plugin_manager::instance()->get_plugins_of_type('logstore') as $plugin) {
        /** @var \tool_log\plugininfo\logstore $plugin */
        $plugin->load_settings($ADMIN, 'logging', $hassiteconfig);
    }
}
