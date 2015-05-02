<?php

/**
 * Adds settings links to admin tree.
 *
 * @package tool_availabilityconditions
 * @copyright 2014 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
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
