<?php

/**
 * Subplugin info class.
 *
 * @package   mod
 * @subpackage book
 * @copyright 2015 Pooya Saeedi
 * 
 */
namespace mod_book\plugininfo;

use core\plugininfo\base;

defined('LION_INTERNAL') || die();


class booktool extends base {
    public function is_uninstall_allowed() {
        return true;
    }
}
