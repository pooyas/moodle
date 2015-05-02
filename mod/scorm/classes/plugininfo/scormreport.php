<?php

/**
 * Subplugin info class.
 *
 * @package   mod_scorm
 * @copyright 2013 Petr Skoda {@link http://skodak.org}
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
