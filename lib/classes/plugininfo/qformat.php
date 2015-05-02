<?php

/**
 * Defines classes used for plugin info.
 *
 * @package    core
 * @copyright  2013 Petr Skoda {@link http://skodak.org}
 * 
 */
namespace core\plugininfo;

defined('LION_INTERNAL') || die();

/**
 * Class for question types
 */
class qformat extends base {
    public function is_uninstall_allowed() {
        return true;
    }
}
