<?php


/**
 * Defines classes used for plugin info.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */
namespace core\plugininfo;

use core_component, core_plugin_manager, lion_url, coding_exception;

defined('LION_INTERNAL') || die();

/**
 * Class for portfolios
 */
class portfolio extends base {
    /**
     * Finds all enabled plugins, the result may include missing plugins.
     * @return array|null of enabled plugins $pluginname=>$pluginname, null means unknown
     */
    public static function get_enabled_plugins() {
        global $DB;

        $enabled = array();
        $rs = $DB->get_recordset('portfolio_instance', array('visible'=>1), 'plugin ASC', 'plugin');
        foreach ($rs as $repository) {
            $enabled[$repository->plugin] = $repository->plugin;
        }

        return $enabled;
    }

    /**
     * Return URL used for management of plugins of this type.
     * @return lion_url
     */
    public static function get_manage_url() {
        return new lion_url('/admin/portfolio.php');
    }

    /**
     * Defines if there should be a way to uninstall the plugin via the administration UI.
     * @return boolean
     */
    public function is_uninstall_allowed() {
        return true;
    }

    /**
     * Pre-uninstall hook.
     * This is intended for disabling of plugin, some DB table purging, etc.
     */
    public function uninstall_cleanup() {
        global $DB;

        // Get all instances of this portfolio.
        $count = $DB->count_records('portfolio_instance', array('plugin' => $this->name));
        if ($count > 0) {
            // This portfolio is in use, get the it's ID.
            $rec = $DB->get_record('portfolio_instance', array('plugin' => $this->name));

            // Remove all records from portfolio_instance_config.
            $DB->delete_records('portfolio_instance_config', array('instance' => $rec->id));
            // Remove all records from portfolio_instance_user.
            $DB->delete_records('portfolio_instance_user', array('instance' => $rec->id));
            // Remove all records from portfolio_log.
            $DB->delete_records('portfolio_log', array('portfolio' => $rec->id));
            // Remove all records from portfolio_tempdata.
            $DB->delete_records('portfolio_tempdata', array('instance' => $rec->id));

            // Remove the record from the portfolio_instance table.
            $DB->delete_records('portfolio_instance', array('id' => $rec->id));
        }

        parent::uninstall_cleanup();
    }
}