<?php

/**
 * Subplugin info class.
 *
 * @package   mod
 * @subpackage scorm
 * @copyright 2015 Pooya Saeedi
 * 
 */
namespace mod_scorm\plugininfo;

use core\plugininfo\base;

defined('LION_INTERNAL') || die();


class scormreport extends base {
    public function is_uninstall_allowed() {
        return true;
    }
}
