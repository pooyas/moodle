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
 * Class for themes
 */
class theme extends base {
    public function is_uninstall_allowed() {
        global $CFG;

        if ($this->name === 'base' or $this->name === 'bootstrapbase') {
            // All of these are protected for now.
            return false;
        }

        if (!empty($CFG->theme) and $CFG->theme === $this->name) {
            // Cannot uninstall default theme.
            return false;
        }

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
        global $DB;

        $DB->set_field('course', 'theme', '', array('theme'=>$this->name));
        $DB->set_field('course_categories', 'theme', '', array('theme'=>$this->name));
        $DB->set_field('user', 'theme', '', array('theme'=>$this->name));
        $DB->set_field('mnet_host', 'theme', '', array('theme'=>$this->name));

        if (get_config('core', 'thememobile') === $this->name) {
            unset_config('thememobile');
        }
        if (get_config('core', 'themetablet') === $this->name) {
            unset_config('themetablet');
        }
        if (get_config('core', 'themelegacy') === $this->name) {
            unset_config('themelegacy');
        }

        $themelist = get_config('core', 'themelist');
        if (!empty($themelist)) {
            $themes = explode(',', $themelist);
            $key = array_search($this->name, $themes);
            if ($key !== false) {
                unset($themes[$key]);
                set_config('themelist', implode(',', $themes));
            }
        }

        parent::uninstall_cleanup();
    }

    /**
     * Return URL used for management of plugins of this type.
     * @return lion_url
     */
    public static function get_manage_url() {
        return new lion_url('/theme/index.php');
    }
}
