<?php


/**
 * PGSQL specific temptables store. Needed because temporary tables
 * are named differently than normal tables. Also used to be able to retrieve
 * temp table names included in the get_tables() method of the DB.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

require_once(__DIR__.'/lion_temptables.php');

class pgsql_native_lion_temptables extends lion_temptables {
    /**
     * Analyze the data in temporary tables to force statistics collection after bulk data loads.
     * PostgreSQL does not natively support automatic temporary table stats collection, so we do it.
     *
     * @return void
     */
    public function update_stats() {
        $temptables = $this->get_temptables();
        foreach ($temptables as $temptablename) {
            $this->mdb->execute("ANALYZE {".$temptablename."}");
        }
    }
}
