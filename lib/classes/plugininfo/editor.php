<?php


/**
 * Defines classes used for plugin info.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */
namespace core\plugininfo;

use lion_url, part_of_admin_tree, admin_settingpage;

defined('LION_INTERNAL') || die();


/**
 * Class for HTML editors
 */
class editor extends base {
    /**
     * Finds all enabled plugins, the result may include missing plugins.
     * @return array|null of enabled plugins $pluginname=>$pluginname, null means unknown
     */
    public static function get_enabled_plugins() {
        global $CFG;

        if (empty($CFG->texteditors)) {
            return array('atto'=>'atto', 'tinymce'=>'tinymce', 'textarea'=>'textarea');
        }

        $enabled = array();
        foreach (explode(',', $CFG->texteditors) as $editor) {
            $enabled[$editor] = $editor;
        }

        return $enabled;
    }

    public function get_settings_section_name() {
        return 'editorsettings' . $this->name;
    }

    public function load_settings(part_of_admin_tree $adminroot, $parentnodename, $hassiteconfig) {
        global $CFG, $USER, $DB, $OUTPUT, $PAGE; // In case settings.php wants to refer to them.
        $ADMIN = $adminroot; // May be used in settings.php.
        $plugininfo = $this; // Also can be used inside settings.php.
        $editor = $this;     // Also can be used inside settings.php.

        if (!$this->is_installed_and_upgraded()) {
            return;
        }

        if (!$hassiteconfig or !file_exists($this->full_path('settings.php'))) {
            return;
        }

        $section = $this->get_settings_section_name();

        $settings = new admin_settingpage($section, $this->displayname, 'lion/site:config', $this->is_enabled() === false);
        include($this->full_path('settings.php')); // This may also set $settings to null.

        if ($settings) {
            $ADMIN->add($parentnodename, $settings);
        }
    }

    /**
     * Basic textarea editor can not be uninstalled.
     */
    public function is_uninstall_allowed() {
        if ($this->name === 'textarea') {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Return URL used for management of plugins of this type.
     * @return lion_url
     */
    public static function get_manage_url() {
        return new lion_url('/admin/settings.php', array('section'=>'manageeditors'));
    }
}
