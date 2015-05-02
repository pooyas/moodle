<?php

/**
 * Subplugin info class.
 *
 * @package   mod_quiz
 * @copyright 2013 Petr Skoda {@link http://skodak.org}
 * 
 */
namespace mod_quiz\plugininfo;

use core\plugininfo\base;

defined('LION_INTERNAL') || die();


class quizaccess extends base {
    public function is_uninstall_allowed() {
        return false;
    }
}
