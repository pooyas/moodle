<?php

/**
 * Subplugin info class.
 *
 * @package   mod_book
 * @copyright 2013 Petr Skoda {@link http://skodak.org}
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
