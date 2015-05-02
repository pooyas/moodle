<?php

/**
 * Class for availability plugins.
 *
 * @package core
 * @copyright 2014 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core\plugininfo;

defined('LION_INTERNAL') || die();

/**
 * Class for availability plugins.
 *
 * @package core
 * @copyright 2014 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class availability extends base {
    public static function get_enabled_plugins() {
        global $DB;

        // Get all available plugins.
        $plugins = \core_plugin_manager::instance()->get_installed_plugins('availability');
        if (!$plugins) {
            return array();
        }

        // Check they are enabled using get_config (which is cached and hopefully fast).
        $enabled = array();
        foreach ($plugins as $plugin => $version) {
            $disabled = get_config('availability_' . $plugin, 'disabled');
            if (empty($disabled)) {
                $enabled[$plugin] = $plugin;
            }
        }

        return $enabled;
    }

    /**
     * Defines if there should be a way to uninstall the plugin via the administration UI.
     *
     * @return bool
     */
    public function is_uninstall_allowed() {
        return true;
    }
}
