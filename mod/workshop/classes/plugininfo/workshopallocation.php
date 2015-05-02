<?php

/**
 * Subplugin info class.
 *
 * @package   mod_workshop
 * @copyright 2013 Petr Skoda {@link http://skodak.org}
 * 
 */
namespace mod_workshop\plugininfo;

use core\plugininfo\base;

defined('LION_INTERNAL') || die();


class workshopallocation extends base {
    public function is_uninstall_allowed() {
        if ($this->is_standard()) {
            return false;
        }
        return true;
    }
}
