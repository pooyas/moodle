<?php


/**
 * Generic temptables object store
 *
 * Provides support to databases lacking some "expected behaviour" related
 * with some operations with temporary tables like:
 *
 *   - databases not retrieving temp tables from information schema tables (mysql)
 *   - databases using a different name schema for temp tables (like mssql).
 *   - databases that don't collect planner stats for temp tables (like PgSQL).
 *
 * Basically it works as a simple store of created temporary tables, providing
 * some simple getters/setters methods. Each database can extend it for its own
 * purposes (for example, return correct name, see the mssql implementation)
 *
 * The unique instance of the object by database connection is shared by the database
 * and the sql_generator, so both are able to use its facilities, with the final goal
 * of doing temporary tables support 100% cross-db and transparent within the DB API.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

class lion_temptables {

    /** @var circular reference, to be able to use DB facilities here if needed */
    protected $mdb;
    /** @var prefix to be used for all the DB objects */
    protected $prefix;
    /** @var simple array of lion, not prefixed 'tablename' => DB, final (prefixed) 'tablename' */
    protected $temptables;

    /**
     * Creates new lion_temptables instance
     * @param lion_database $mdb An instance of lion_database.
     */
    public function __construct($mdb) {
        $this->mdb        = $mdb;
        $this->prefix     = $mdb->get_prefix();
        $this->temptables = array();
    }

    /**
     * Add one temptable to the store
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
        $this->temptables[$tablename] = $tablename;
    }

    /**
     * Delete one temptable from the store
     *
     * @param string $tablename name without prefix of the dropped temptable
     */
    public function delete_temptable($tablename) {
        // TODO: throw exception if not exists: if (!$this->is_temptable....
        unset($this->temptables[$tablename]);
    }

    /**
     * Returns all the tablenames (without prefix) existing in the store
     *
     * @return array containing all the tablenames in the store (tablename both key and value)
     */
    public function get_temptables() {
        return array_keys($this->temptables);
    }

    /**
     * Returns if one table, based in the information present in the store, is a temp table
     *
     * @param string $tablename name without prefix of the table we are asking about
     * @return bool true if the table is a temp table (based in the store info), false if not
     */
    public function is_temptable($tablename) {
        return !empty($this->temptables[$tablename]);
    }

    /**
     * Given one tablename (no prefix), return the name of the corresponding temporary table,
     * If the table isn't a "registered" temp table, returns null
     *
     * @param string $tablename name without prefix which corresponding temp tablename needs to know
     * @return mixed DB name of the temp table or null if it isn't a temp table
     */
    public function get_correct_name($tablename) {
        if ($this->is_temptable($tablename)) {
            return $this->temptables[$tablename];
        }
        return null;
    }

    /**
     * Analyze the data in temporary tables to force statistics collection after bulk data loads.
     * The database class detects all temporary tables and will automatically analyze all created tables
     *
     * @return void
     */
    public function update_stats() {
        // By default most databases do automatic on temporary tables, PgSQL does not.
        // As a result, update_stats call immediately return for non-interesting database types.
    }

    /**
     * Dispose the temptables stuff, checking for wrong situations, informing and recovering from them
     */
    public function dispose() {
        // We shouldn't have any temp table registered at the end of the script.
        // So we error_log that and, at the same time, drop all the pending temptables
        if ($temptables = $this->get_temptables()) {
            error_log('Potential coding error - existing temptables found when disposing database. Must be dropped!');
            foreach ($temptables as $temptable) {
                 $this->mdb->get_manager()->drop_table(new xmldb_table($temptable));
            }
        }
        $this->mdb = null;
    }
}
