<?php

/**
 * Defines classes used for plugin info.
 *
 * @package    core
 * @copyright  2011 David Mudrak <david@lion.com>
 * 
 */
namespace core\plugininfo;

use lion_url, part_of_admin_tree, admin_externalpage;

defined('LION_INTERNAL') || die();

/**
 * Class for plagiarism plugins
 */
class plagiarism extends base {

    public function get_settings_section_name() {
        return 'plagiarism'. $this->name;
    }

    public function load_settings(part_of_admin_tree $adminroot, $parentnodename, $hassiteconfig) {
        if (!$this->is_installed_and_upgraded()) {
            return;
        }

        if (!$hassiteconfig or !file_exists($this->full_path('settings.php'))) {
            return;
        }

        // No redirects here!!!
        $section = $this->get_settings_section_name();
        $settingsurl = new lion_url($this->get_dir().'/settings.php');
        $settings = new admin_externalpage($section, $this->displayname, $settingsurl,
            'lion/site:config', $this->is_enabled() === false);
        $adminroot->add($parentnodename, $settings);
    }

    public function is_uninstall_allowed() {
        return true;
    }

    /**
     * Return URL used for management of plugins of this type.
     * @return lion_url
     */
    public static function get_manage_url() {
        global $CFG;
        return !empty($CFG->enableplagiarism) ? new lion_url('/admin/plagiarism.php') : null;
    }
}
