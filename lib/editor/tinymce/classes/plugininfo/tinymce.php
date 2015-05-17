<?php


/**
 * Subplugin info class.
 *
 * @package    editor
 * @subpackage tinymce
 * @copyright  2015 Pooya Saeedi
 */
namespace editor_tinymce\plugininfo;

use core\plugininfo\base, lion_url, part_of_admin_tree, admin_settingpage, core_component;

defined('LION_INTERNAL') || die();


class tinymce extends base {
    /**
     * Finds all enabled plugins, the result may include missing plugins.
     * @return array|null of enabled plugins $pluginname=>$pluginname, null means unknown
     */
    public static function get_enabled_plugins() {
        $disabledsubplugins = array();
        $config = get_config('editor_tinymce', 'disabledsubplugins');
        if ($config) {
            $config = explode(',', $config);
            foreach ($config as $sp) {
                $sp = trim($sp);
                if ($sp !== '') {
                    $disabledsubplugins[$sp] = $sp;
                }
            }
        }

        $enabled = array();
        $installed = core_component::get_plugin_list('tinymce');
        foreach ($installed as $plugin => $fulldir) {
            if (isset($disabledsubplugins[$plugin])) {
                continue;
            }
            $enabled[$plugin] = $plugin;
        }

        return $enabled;
    }

    public function is_uninstall_allowed() {
        return true;
    }

    /**
     * Return URL used for management of plugins of this type.
     * @return lion_url
     */
    public static function get_manage_url() {
        return new lion_url('/admin/settings.php', array('section'=>'editorsettingstinymce'));
    }

    public function get_settings_section_name() {
        return 'tinymce'.$this->name.'settings';
    }

    public function load_settings(part_of_admin_tree $adminroot, $parentnodename, $hassiteconfig) {
        global $CFG, $USER, $DB, $OUTPUT, $PAGE; // In case settings.php wants to refer to them.
        $ADMIN = $adminroot; // May be used in settings.php.
        $plugininfo = $this; // Also can be used inside settings.php.

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
}
