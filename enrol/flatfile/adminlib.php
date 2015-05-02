<?php

/**
 * Special flatfile settings.
 *
 * @package    enrol_flatfile
 * @copyright  2013 Petr Skoda {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die();

require_once("$CFG->libdir/adminlib.php");


/**
 * Setting class that stores only non-empty values.
 */
class enrol_flatfile_role_setting extends admin_setting_configtext {

    public function __construct($role) {
        parent::__construct('enrol_flatfile/map_'.$role->id, $role->localname, '', $role->shortname);
    }

    public function config_read($name) {
        $value = parent::config_read($name);
        if (is_null($value)) {
            // In other settings NULL means we have to ask user for new value,
            // here we just ignore missing role mappings.
            $value = '';
        }
        return $value;
    }

    public function config_write($name, $value) {
        if ($value === '') {
            // We do not want empty values in config table,
            // delete it instead.
            $value = null;
        }
        return parent::config_write($name, $value);
    }
}
