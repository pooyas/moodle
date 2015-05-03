<?php

/**
 * Defines classes used for plugin info.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */
namespace core\plugininfo;

defined('LION_INTERNAL') || die();

/**
 * Class for calendar type plugins.
 */
class calendartype extends base {

    public function is_uninstall_allowed() {
        // We can delete all calendar types, except Gregorian. Gregorian comes with core and was the calendar
        // type used before the calendar types were introduced as plugins in Lion. If all calendar types were
        // deleted then Lion would break completely wherever any dates are displayed.
        if ($this->name !== 'gregorian') {
            return true;
        }

        return false;
    }

    public function get_settings_section_name() {
        return 'calendartype_' . $this->name . '_settings';
    }

    public function load_settings(part_of_admin_tree $adminroot, $parentnodename, $hassiteconfig) {
        global $CFG, $USER, $DB, $OUTPUT, $PAGE; // In case settings.php wants to refer to them.
        $ADMIN = $adminroot; // May be used in settings.php.
        $plugininfo = $this; // Also can be used inside settings.php.
        $qtype = $this;      // Also can be used inside settings.php.

        if (!$this->is_installed_and_upgraded()) {
            return;
        }

        $section = $this->get_settings_section_name();

        $settings = null;
        $systemcontext = \context_system::instance();
        if (($hassiteconfig) &&
            file_exists($this->full_path('settings.php'))) {
            $settings = new admin_settingpage($section, $this->displayname,
                'lion/site:config', $this->is_enabled() === false);
            include($this->full_path('settings.php')); // This may also set $settings to null.
        }
        if ($settings) {
            $ADMIN->add($parentnodename, $settings);
        }
    }
}
