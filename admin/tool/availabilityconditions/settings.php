<?php


/**
 * Adds settings links to admin tree.
 *
 * @package    admin_tool
 * @subpackage availabilityconditions
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

if ($hassiteconfig && !empty($CFG->enableavailability)) {
    $ADMIN->add('modules', new admin_category('availabilitysettings',
            new lang_string('type_availability_plural', 'plugin')));
    $ADMIN->add('availabilitysettings', new admin_externalpage('manageavailability',
            new lang_string('manageplugins', 'tool_availabilityconditions'),
            $CFG->wwwroot . '/' . $CFG->admin . '/tool/availabilityconditions/'));
    foreach (core_plugin_manager::instance()->get_plugins_of_type('availability') as $plugin) {
        /** @var \core\plugininfo\format $plugin */
        $plugin->load_settings($ADMIN, 'availabilitysettings', $hassiteconfig);
    }
}
