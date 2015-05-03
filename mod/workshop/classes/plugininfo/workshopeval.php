<?php

/**
 * Subplugin info class.
 *
 * @package   mod_workshop
 * @copyright 2015 Pooya Saeedi
 * 
 */
namespace mod_workshop\plugininfo;

use core\plugininfo\base;

defined('LION_INTERNAL') || die();


class workshopeval extends base {
    public function is_uninstall_allowed() {
        if ($this->is_standard()) {
            return false;
        }
        return true;
    }
}
