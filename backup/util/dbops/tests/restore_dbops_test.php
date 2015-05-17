<?php


/**
 * @category   phpunit
 * @package    backup
 * @subpackage util
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

// Include all the needed stuff
global $CFG;
require_once($CFG->dirroot . '/backup/util/includes/restore_includes.php');

/**
 * Restore dbops tests (all).
 */
class restore_dbops_testcase extends advanced_testcase {

    /**
     * Verify the xxx_ids_cached (in-memory backup_ids cache) stuff works as expected.
     *
     * Note that those private implementations are tested here by using the public
     * backup_ids API and later performing low-level tests.
     */
    public function test_backup_ids_cached() {
        global $DB;
        $dbman = $DB->get_manager(); // We are going to use database_manager services.

        $this->resetAfterTest(true); // Playing with temp tables, better reset once finished.

        // Some variables and objects for testing.
        $restoreid = 'testrestoreid';

        $mapping = new stdClass();
        $mapping->itemname = 'user';
        $mapping->itemid = 1;
        $mapping->newitemid = 2;
        $mapping->parentitemid = 3;
        $mapping->info = 'info';

        // Create the backup_ids temp tables used by restore.
        restore_controller_dbops::create_restore_temp_tables($restoreid);

        // Send one mapping using the public api with defaults.
        restore_dbops::set_backup_ids_record($restoreid, $mapping->itemname, $mapping->itemid);
        // Get that mapping and verify everything is returned as expected.
        $result = restore_dbops::get_backup_ids_record($restoreid, $mapping->itemname, $mapping->itemid);
        $this->assertSame($mapping->itemname, $result->itemname);
        $this->assertSame($mapping->itemid, $result->itemid);
        $this->assertSame(0, $result->newitemid);
        $this->assertSame(null, $result->parentitemid);
        $this->assertSame(null, $result->info);

        // Drop the backup_xxx_temp temptables manually, so memory cache won't be invalidated.
        $dbman->drop_table(new xmldb_table('backup_ids_temp'));
        $dbman->drop_table(new xmldb_table('backup_files_temp'));

        // Verify the mapping continues returning the same info,
        // now from cache (the table does not exist).
        $result = restore_dbops::get_backup_ids_record($restoreid, $mapping->itemname, $mapping->itemid);
        $this->assertSame($mapping->itemname, $result->itemname);
        $this->assertSame($mapping->itemid, $result->itemid);
        $this->assertSame(0, $result->newitemid);
        $this->assertSame(null, $result->parentitemid);
        $this->assertSame(null, $result->info);

        // Recreate the temp table, just to drop it using the restore API in
        // order to check that, then, the cache becomes invalid for the same request.
        restore_controller_dbops::create_restore_temp_tables($restoreid);
        restore_controller_dbops::drop_restore_temp_tables($restoreid);

        // No cached info anymore, so the mapping request will arrive to
        // DB leading to error (temp table does not exist).
        try {
            $result = restore_dbops::get_backup_ids_record($restoreid, $mapping->itemname, $mapping->itemid);
            $this->fail('Expecting an exception, none occurred');
        } catch (Exception $e) {
            $this->assertTrue($e instanceof dml_exception);
            $this->assertSame('Table "backup_ids_temp" does not exist', $e->getMessage());
        }

        // Create the backup_ids temp tables once more.
        restore_controller_dbops::create_restore_temp_tables($restoreid);

        // Send one mapping using the public api with complete values.
        restore_dbops::set_backup_ids_record($restoreid, $mapping->itemname, $mapping->itemid,
                $mapping->newitemid, $mapping->parentitemid, $mapping->info);
        // Get that mapping and verify everything is returned as expected.
        $result = restore_dbops::get_backup_ids_record($restoreid, $mapping->itemname, $mapping->itemid);
        $this->assertSame($mapping->itemname, $result->itemname);
        $this->assertSame($mapping->itemid, $result->itemid);
        $this->assertSame($mapping->newitemid, $result->newitemid);
        $this->assertSame($mapping->parentitemid, $result->parentitemid);
        $this->assertSame($mapping->info, $result->info);

        // Finally, drop the temp tables properly and get the DB error again (memory caches empty).
        restore_controller_dbops::drop_restore_temp_tables($restoreid);
        try {
            $result = restore_dbops::get_backup_ids_record($restoreid, $mapping->itemname, $mapping->itemid);
            $this->fail('Expecting an exception, none occurred');
        } catch (Exception $e) {
            $this->assertTrue($e instanceof dml_exception);
            $this->assertSame('Table "backup_ids_temp" does not exist', $e->getMessage());
        }
    }
}
