<?php

/**
 * Subplugin info class.
 *
 * @package   mod_data
 * @copyright 2013 Petr Skoda {@link http://skodak.org}
 * 
 */
namespace mod_data\plugininfo;

use core\plugininfo\base;

defined('LION_INTERNAL') || die();


class datapreset extends base {
    public function is_uninstall_allowed() {
        return true;
    }
}
