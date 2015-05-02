<?php

/**
 * Defines classes used for plugin info.
 *
 * @package    core
 * @copyright  2011 David Mudrak <david@lion.com>
 * 
 */
namespace core\plugininfo;

use lion_url, part_of_admin_tree, admin_settingpage;

defined('LION_INTERNAL') || die();

/**
 * Class for messaging processors
 */
class message extends base {
    /**
     * Finds all enabled plugins, the result may include missing plugins.
     * @return array|null of enabled plugins $pluginname=>$pluginname, null means unknown
     */
    public static function get_enabled_plugins() {
        global $DB;
        return $DB->get_records_menu('message_processors', array('enabled'=>1), 'name ASC', 'name, name AS val');
    }

    public function get_settings_section_name() {
        return 'messagesetting' . $this->name;
    }

    public function load_settings(part_of_admin_tree $adminroot, $parentnodename, $hassiteconfig) {
        global $CFG, $USER, $DB, $OUTPUT, $PAGE; // In case settings.php wants to refer to them.
        $ADMIN = $adminroot; // May be used in settings.php.
        $plugininfo = $this; // Also can be used inside settings.php.

        if (!$this->is_installed_and_upgraded()) {
            return;
        }

        if (!$hassiteconfig) {
            return;
        }
        $section = $this->get_settings_section_name();

        $settings = null;
        $processors = get_message_processors();
        if (isset($processors[$this->name])) {
            $processor = $processors[$this->name];
            if ($processor->available && $processor->hassettings) {
                $settings = new admin_settingpage($section, $this->displayname,
                    'lion/site:config', $this->is_enabled() === false);
                include($this->full_path('settings.php')); // This may also set $settings to null.
            }
        }
        if ($settings) {
            $ADMIN->add($parentnodename, $settings);
        }
    }

    /**
     * Return URL used for management of plugins of this type.
     * @return lion_url
     */
    public static function get_manage_url() {
        return new lion_url('/admin/message.php');
    }

    public function is_uninstall_allowed() {
        return true;
    }

    /**
     * Pre-uninstall hook.
     *
     * This is intended for disabling of plugin, some DB table purging, etc.
     *
     * NOTE: to be called from uninstall_plugin() only.
     * @private
     */
    public function uninstall_cleanup() {
        global $CFG;

        require_once($CFG->libdir.'/messagelib.php');
        message_processor_uninstall($this->name);

        parent::uninstall_cleanup();
    }
}
