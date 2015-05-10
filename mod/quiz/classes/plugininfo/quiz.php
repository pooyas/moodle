<?php

/**
 * Subplugin info class.
 *
 * @package   mod
 * @subpackage quiz
 * @copyright 2015 Pooya Saeedi
 * 
 */
namespace mod_quiz\plugininfo;

use core\plugininfo\base;

defined('LION_INTERNAL') || die();


class quiz extends base {
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
        global $DB;

        // Do the opposite of db/install.php scripts - deregister the report.

        $DB->delete_records('quiz_reports', array('name'=>$this->name));

        parent::uninstall_cleanup();
    }
}
