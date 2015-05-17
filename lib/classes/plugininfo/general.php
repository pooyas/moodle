<?php


/**
 * Defines classes used for plugin info.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
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
