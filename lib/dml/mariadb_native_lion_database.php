<?php

/**
 * Native MariaDB class representing lion database interface.
 *
 * @package    core_dml
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

require_once(__DIR__.'/lion_database.php');
require_once(__DIR__.'/mysqli_native_lion_database.php');
require_once(__DIR__.'/mysqli_native_lion_recordset.php');
require_once(__DIR__.'/mysqli_native_lion_temptables.php');

/**
 * Native MariaDB class representing lion database interface.
 *
 * @package    core_dml
 * @copyright  2015 Pooya Saeedi
 * 
 */
class mariadb_native_lion_database extends mysqli_native_lion_database {

    /**
     * Returns localised database type name
     * Note: can be used before connect()
     * @return string
     */
    public function get_name() {
        return get_string('nativemariadb', 'install');
    }

    /**
     * Returns localised database configuration help.
     * Note: can be used before connect()
     * @return string
     */
    public function get_configuration_help() {
        return get_string('nativemariadbhelp', 'install');
    }

    /**
     * Returns the database vendor.
     * Note: can be used before connect()
     * @return string The db vendor name, usually the same as db family name.
     */
    public function get_dbvendor() {
        return 'mariadb';
    }

    /**
     * Returns more specific database driver type
     * Note: can be used before connect()
     * @return string db type mysqli, pgsql, oci, mssql, sqlsrv
     */
    protected function get_dbtype() {
        return 'mariadb';
    }

    /**
     * Returns database server info array
     * @return array Array containing 'description' and 'version' info
     */
    public function get_server_info() {
        $version = $this->mysqli->server_info;
        $matches = null;
        if (preg_match('/^5\.5\.5-(10\..+)-MariaDB/i', $version, $matches)) {
            // Looks like MariaDB decided to use these weird version numbers for better BC with MySQL...
            $version = $matches[1];
        }
        return array('description'=>$this->mysqli->server_info, 'version'=>$version);
    }

    /**
     * It is time to require transactions everywhere.
     *
     * MyISAM is NOT supported!
     *
     * @return bool
     */
    protected function transactions_supported() {
        if ($this->external) {
            return parent::transactions_supported();
        }
        return true;
    }
}
