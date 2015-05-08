<?php

/**
 * MSSQL specific temptables store. Needed because temporary tables
 * are named differently than normal tables. Also used to be able to retrieve
 * temp table names included in the get_tables() method of the DB.
 *
 * @package    core
 * @subpackage dml
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

require_once(__DIR__.'/lion_temptables.php');

class mssql_native_lion_temptables extends lion_temptables {

    /**
     * Add one temptable to the store.
     *
     * Overriden because MSSQL requires to add # for local (session) temporary
     * tables before the prefix.
     *
     * Given one lion temptable name (without prefix), add it to the store, with the
     * key being the original lion name and the value being the real db temptable name
     * already prefixed
     *
     * Override and use this *only* if the database requires modification in the table name.
     *
     * @param string $tablename name without prefix of the table created as temptable
     */
    public function add_temptable($tablename) {
        // TODO: throw exception if exists: if ($this->is_temptable...
        $this->temptables[$tablename] = '#' . $this->prefix . $tablename;
    }
}
