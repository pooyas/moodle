<?php

/**
 * Helper class locally used.
 *
 * @package    logstore_database
 * @copyright  2014 onwards Ankit Agarwal
 * 
 */

namespace logstore_database;
defined('LION_INTERNAL') || die();


/**
 * Helper class locally used.
 *
 * @copyright  2014 onwards Ankit Agarwal
 * 
 */
class helper {
    /**
     * Returns list of fully working database drivers present in system.
     * @return array
     */
    public static function get_drivers() {
        return array(
            ''               => get_string('choosedots'),
            'native/mysqli'  => \lion_database::get_driver_instance('mysqli', 'native')->get_name(),
            'native/mariadb' => \lion_database::get_driver_instance('mariadb', 'native')->get_name(),
            'native/pgsql'   => \lion_database::get_driver_instance('pgsql', 'native')->get_name(),
            'native/oci'     => \lion_database::get_driver_instance('oci', 'native')->get_name(),
            'native/sqlsrv'  => \lion_database::get_driver_instance('sqlsrv', 'native')->get_name(),
            'native/mssql'   => \lion_database::get_driver_instance('mssql', 'native')->get_name()
        );
    }

    /**
     * Get a list of edu levels.
     *
     * @return array
     */
    public static function get_level_options() {
        return array(
            \core\event\base::LEVEL_TEACHING      => get_string('teaching', 'logstore_database'),
            \core\event\base::LEVEL_PARTICIPATING => get_string('participating', 'logstore_database'),
            \core\event\base::LEVEL_OTHER         => get_string('other', 'logstore_database'),
        );
    }

    /**
     * Get a list of database actions.
     *
     * @return array
     */
    public static function get_action_options() {
        return array(
            'c' => get_string('create', 'logstore_database'),
            'r' => get_string('read', 'logstore_database'),
            'u' => get_string('update', 'logstore_database'),
            'd' => get_string('delete')
        );
    }
}
