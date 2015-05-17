<?php


/**
 * Subplugin info class.
 *
 * @package    mod
 * @subpackage data
 * @copyright  2015 Pooya Saeedi
 */
namespace mod_data\plugininfo;

use core\plugininfo\base;

defined('LION_INTERNAL') || die();


class datapreset extends base {
    public function is_uninstall_allowed() {
        return true;
    }
}
