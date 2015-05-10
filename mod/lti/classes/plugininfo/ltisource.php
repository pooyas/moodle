<?php

/**
 * LTI source plugin info.
 *
 * @package   mod
 * @subpackage lti
 * @copyright 2015 Pooya Saeedi
 * 
 */
namespace mod_lti\plugininfo;

use core\plugininfo\base;

defined('LION_INTERNAL') || die();


class ltisource extends base {
    /**
     * Returns the node name used in admin settings menu for this plugin settings (if applicable)
     *
     * @return null|string node name or null if plugin does not create settings node (default)
     */
    public function get_settings_section_name() {
        return 'ltisourcesetting'.$this->name;
    }

    /**
     * Loads plugin settings to the settings tree
     *
     * This function usually includes settings.php file in plugins folder.
     * Alternatively it can create a link to some settings page (instance of admin_externalpage)
     *
     * @param \part_of_admin_tree $adminroot
     * @param string $parentnodename
     * @param bool $hassiteconfig whether the current user has lion/site:config capability
     */
    public function load_settings(\part_of_admin_tree $adminroot, $parentnodename, $hassiteconfig) {
        global $CFG, $USER, $DB, $OUTPUT, $PAGE; // In case settings.php wants to refer to them.
        $ADMIN      = $adminroot; // May be used in settings.php.
        $plugininfo = $this; // Also can be used inside settings.php.

        if (!$this->is_installed_and_upgraded()) {
            return;
        }
        if (!$hassiteconfig or !file_exists($this->full_path('settings.php'))) {
            return;
        }
        $section  = $this->get_settings_section_name();
        $settings = new \admin_settingpage($section, $this->displayname,
            'lion/site:config', $this->is_enabled() === false);

        include($this->full_path('settings.php')); // This may also set $settings to null.

        if ($settings) {
            $ADMIN->add($parentnodename, $settings);
        }
    }
}
