<?php

/**
 * Defines classes used for plugin info.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */
namespace core\plugininfo;

use lion_url, core_plugin_manager;

defined('LION_INTERNAL') || die();

/**
 * Class for question behaviours.
 */
class qbehaviour extends base {
    /**
     * Finds all enabled plugins, the result may include missing plugins.
     * @return array|null of enabled plugins $pluginname=>$pluginname, null means unknown
     */
    public static function get_enabled_plugins() {
        $plugins = core_plugin_manager::instance()->get_installed_plugins('qbehaviour');
        if (!$plugins) {
            return array();
        }
        if ($disabled = get_config('question', 'disabledbehaviours')) {
            $disabled = explode(',', $disabled);
        } else {
            $disabled = array();
        }

        $enabled = array();
        foreach ($plugins as $plugin => $version) {
            if (in_array($plugin, $disabled)) {
                continue;
            }
            $enabled[$plugin] = $plugin;
        }

        return $enabled;
    }

    public function is_uninstall_allowed() {
        global $DB;

        if ($this->name === 'missing') {
            // qbehaviour_missing is used by the system. It cannot be uninstalled.
            return false;
        }

        return !$DB->record_exists('question_attempts', array('behaviour' => $this->name));
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
        if ($disabledbehaviours = get_config('question', 'disabledbehaviours')) {
            $disabledbehaviours = explode(',', $disabledbehaviours);
            $disabledbehaviours = array_unique($disabledbehaviours);
        } else {
            $disabledbehaviours = array();
        }
        if (($key = array_search($this->name, $disabledbehaviours)) !== false) {
            unset($disabledbehaviours[$key]);
            set_config('disabledbehaviours', implode(',', $disabledbehaviours), 'question');
        }

        if ($behaviourorder = get_config('question', 'behavioursortorder')) {
            $behaviourorder = explode(',', $behaviourorder);
            $behaviourorder = array_unique($behaviourorder);
        } else {
            $behaviourorder = array();
        }
        if (($key = array_search($this->name, $behaviourorder)) !== false) {
            unset($behaviourorder[$key]);
            set_config('behavioursortorder', implode(',', $behaviourorder), 'question');
        }

        parent::uninstall_cleanup();
    }

    /**
     * Return URL used for management of plugins of this type.
     * @return lion_url
     */
    public static function get_manage_url() {
        return new lion_url('/admin/qbehaviours.php');
    }
}

