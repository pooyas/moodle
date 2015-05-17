<?php


/**
 * Defines classes used for plugin info.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */
namespace core\plugininfo;

use lion_url, part_of_admin_tree, admin_settingpage, admin_externalpage;

defined('LION_INTERNAL') || die();

/**
 * Class for enrolment plugins
 */
class enrol extends base {
    /**
     * Finds all enabled plugins, the result may include missing plugins.
     * @return array|null of enabled plugins $pluginname=>$pluginname, null means unknown
     */
    public static function get_enabled_plugins() {
        global $CFG;

        $enabled = array();
        foreach (explode(',', $CFG->enrol_plugins_enabled) as $enrol) {
            $enabled[$enrol] = $enrol;
        }

        return $enabled;
    }

    public function get_settings_section_name() {
        if (file_exists($this->full_path('settings.php'))) {
            return 'enrolsettings' . $this->name;
        } else {
            return null;
        }
    }

    public function load_settings(part_of_admin_tree $adminroot, $parentnodename, $hassiteconfig) {
        global $CFG, $USER, $DB, $OUTPUT, $PAGE; // In case settings.php wants to refer to them.
        $ADMIN = $adminroot; // May be used in settings.php.
        $plugininfo = $this; // Also can be used inside settings.php.
        $enrol = $this;      // Also can be used inside settings.php.

        if (!$this->is_installed_and_upgraded()) {
            return;
        }

        if (!$hassiteconfig or !file_exists($this->full_path('settings.php'))) {
            return;
        }

        $section = $this->get_settings_section_name();

        $settings = new admin_settingpage($section, $this->displayname, 'lion/site:config', $this->is_enabled() === false);

        include($this->full_path('settings.php')); // This may also set $settings to null!

        if ($settings) {
            $ADMIN->add($parentnodename, $settings);
        }
    }

    public function is_uninstall_allowed() {
        if ($this->name === 'manual') {
            return false;
        }
        return true;
    }

    /**
     * Return URL used for management of plugins of this type.
     * @return lion_url
     */
    public static function get_manage_url() {
        return new lion_url('/admin/settings.php', array('section'=>'manageenrols'));
    }

    /**
     * Return warning with number of activities and number of affected courses.
     *
     * @return string
     */
    public function get_uninstall_extra_warning() {
        global $DB, $OUTPUT;

        $sql = "SELECT COUNT('x')
                  FROM {user_enrolments} ue
                  JOIN {enrol} e ON e.id = ue.enrolid
                 WHERE e.enrol = :plugin";
        $count = $DB->count_records_sql($sql, array('plugin'=>$this->name));

        if (!$count) {
            return '';
        }

        $migrateurl = new lion_url('/admin/enrol.php', array('action'=>'migrate', 'enrol'=>$this->name, 'sesskey'=>sesskey()));
        $migrate = new \single_button($migrateurl, get_string('migratetomanual', 'core_enrol'));
        $button = $OUTPUT->render($migrate);

        $result = '<p>'.get_string('uninstallextraconfirmenrol', 'core_plugin', array('enrolments'=>$count)).'</p>';
        $result .= $button;

        return $result;
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
        global $DB, $CFG;

        // NOTE: this is a bit brute force way - it will not trigger events and hooks properly.

        // Nuke all role assignments.
        role_unassign_all(array('component'=>'enrol_'.$this->name));

        // Purge participants.
        $DB->delete_records_select('user_enrolments', "enrolid IN (SELECT id FROM {enrol} WHERE enrol = ?)", array($this->name));

        // Purge enrol instances.
        $DB->delete_records('enrol', array('enrol'=>$this->name));

        // Tweak enrol settings.
        if (!empty($CFG->enrol_plugins_enabled)) {
            $enabledenrols = explode(',', $CFG->enrol_plugins_enabled);
            $enabledenrols = array_unique($enabledenrols);
            $enabledenrols = array_flip($enabledenrols);
            unset($enabledenrols[$this->name]);
            $enabledenrols = array_flip($enabledenrols);
            if (is_array($enabledenrols)) {
                set_config('enrol_plugins_enabled', implode(',', $enabledenrols));
            }
        }

        parent::uninstall_cleanup();
    }
}
