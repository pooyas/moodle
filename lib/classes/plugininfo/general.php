<?php

/**
 * Defines classes used for plugin info.
 *
 * @package    core
 * @copyright  2011 David Mudrak <david@lion.com>
 * 
 */
namespace core\plugininfo;

defined('LION_INTERNAL') || die();


/**
 * General class for all plugin types that do not have their own class
 */
class general extends base {
    public function is_uninstall_allowed() {
        return false;
    }
}
