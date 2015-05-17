<?php


/**
 * Defines classes used for plugin info.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */
namespace core\plugininfo;

use lion_url, part_of_admin_tree, admin_externalpage;

defined('LION_INTERNAL') || die();

/**
 * Class for repositories
 */
class repository extends base {
    /**
     * Finds all enabled plugins, the result may include missing plugins.
     * @return array|null of enabled plugins $pluginname=>$pluginname, null means unknown
     */
    public static function get_enabled_plugins() {
        global $DB;
        return $DB->get_records_menu('repository', array('visible'=>1), 'type ASC', 'type, type AS val');
    }

    public function get_settings_section_name() {
        return 'repositorysettings'.$this->name;
    }

    public function load_settings(part_of_admin_tree $adminroot, $parentnodename, $hassiteconfig) {
        if (!$this->is_installed_and_upgraded()) {
            return;
        }

        if ($hassiteconfig && $this->is_enabled()) {
            // Completely no access to repository setting when it is not enabled.
            $sectionname = $this->get_settings_section_name();
            $settingsurl = new lion_url('/admin/repository.php',
                array('sesskey' => sesskey(), 'action' => 'edit', 'repos' => $this->name));
            $settings = new admin_externalpage($sectionname, $this->displayname,
                $settingsurl, 'lion/site:config', false);
            $adminroot->add($parentnodename, $settings);
        }
    }

    /**
     * Return URL used for management of plugins of this type.
     * @return lion_url
     */
    public static function get_manage_url() {
        return new lion_url('/admin/repository.php');
    }
}
