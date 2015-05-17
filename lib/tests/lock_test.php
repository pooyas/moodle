<?php


/**
 * lock unit tests
 *
 * @category   test
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();


/**
 * Unit tests for our locking implementations.
 *
 * @category   test
 */
class lock_testcase extends advanced_testcase {

    /**
     * Some lock types will store data in the database.
     */
    protected function setUp() {
        $this->resetAfterTest(true);
    }

    /**
     * Run a suite of tests on a lock factory.
     * @param \core\lock\lock_factory $lockfactory - A lock factory to test
     */
    protected function run_on_lock_factory(\core\lock\lock_factory $lockfactory) {

        if ($lockfactory->is_available()) {
            // This should work.
            $lock1 = $lockfactory->get_lock('abc', 2);
            $this->assertNotEmpty($lock1, 'Get a lock');

            if ($lockfactory->supports_timeout()) {
                if ($lockfactory->supports_recursion()) {
                    $lock2 = $lockfactory->get_lock('abc', 2);
                    $this->assertNotEmpty($lock2, 'Get a stacked lock');
                    $this->assertTrue($lock2->release(), 'Release a stacked lock');
                } else {
                    // This should timeout.
                    $lock2 = $lockfactory->get_lock('abc', 2);
                    $this->assertFalse($lock2, 'Cannot get a stacked lock');
                }
            }
            // Release the lock.
            $this->assertTrue($lock1->release(), 'Release a lock');
            // Get it again.
            $lock3 = $lockfactory->get_lock('abc', 2);

            $this->assertNotEmpty($lock3, 'Get a lock again');
            // Release the lock again.
            $this->assertTrue($lock3->release(), 'Release a lock again');
            // Release the lock again (shouldn't hurt).
            $this->assertFalse($lock3->release(), 'Release a lock that is not held');
            if (!$lockfactory->supports_auto_release()) {
                // Test that a lock can be claimed after the timeout period.
                $lock4 = $lockfactory->get_lock('abc', 2, 2);
                $this->assertNotEmpty($lock4, 'Get a lock');
                sleep(3);

                $lock5 = $lockfactory->get_lock('abc', 2, 2);
                $this->assertNotEmpty($lock5, 'Get another lock after a timeout');
                $this->assertTrue($lock5->release(), 'Release the lock');
                $this->assertTrue($lock4->release(), 'Release the lock');
            }
        }
    }

    /**
     * Tests the testable lock factories.
     * @return void
     */
    public function test_locks() {
        // Run the suite on the current configured default (may be non-core).
        $defaultfactory = \core\lock\lock_config::get_lock_factory('default');
        $this->run_on_lock_factory($defaultfactory);

        // Manually create the core no-configuration factories.
        $dblockfactory = new \core\lock\db_record_lock_factory('test');
        $this->run_on_lock_factory($dblockfactory);

        $filelockfactory = new \core\lock\file_lock_factory('test');
        $this->run_on_lock_factory($filelockfactory);

    }

}

