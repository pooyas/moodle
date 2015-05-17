<?php


/**
 * Defines classes used for plugin info.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */
namespace core\plugininfo;

use lion_url;

defined('LION_INTERNAL') || die();

/**
 * Class for local plugins
 */
class local extends base {

    public function is_uninstall_allowed() {
        return true;
    }

    /**
     * Return URL used for management of plugins of this type.
     * @return lion_url
     */
    public static function get_manage_url() {
        return new lion_url('/admin/localplugins.php');
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
        $ADMIN = $adminroot; // May be used in settings.php.
        $plugininfo = $this; // Also can be used inside settings.php.

        if (!$this->is_installed_and_upgraded()) {
            return;
        }

        if (file_exists($this->full_path('settings.php'))) {
            include($this->full_path('settings.php'));
        }
    }
}
