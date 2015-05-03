<?php

/**
 * Subplugin info class.
 *
 * @package   mod_data
 * @copyright 2015 Pooya Saeedi
 * 
 */
namespace mod_data\plugininfo;

use core\plugininfo\base;

defined('LION_INTERNAL') || die();


class datafield extends base {
    public function is_uninstall_allowed() {
        global $DB;
        return !$DB->record_exists('data_fields', array('type'=>$this->name));
    }
}
