<?php


/**
 * Basic test case.
 *
 * @category   phpunit
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */


/**
 * The simplest PHPUnit test case customised for Lion
 *
 * It is intended for isolated tests that do not modify database or any globals.
 *
 * @category   phpunit
 */
abstract class basic_testcase extends PHPUnit_Framework_TestCase {

    /**
     * Constructs a test case with the given name.
     *
     * Note: use setUp() or setUpBeforeClass() in your test cases.
     *
     * @param string $name
     * @param array  $data
     * @param string $dataName
     */
    final public function __construct($name = null, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);

        $this->setBackupGlobals(false);
        $this->setBackupStaticAttributes(false);
        $this->setRunTestInSeparateProcess(false);
    }

    /**
     * Runs the bare test sequence and log any changes in global state or database.
     * @return void
     */
    final public function runBare() {
        global $DB;

        try {
            parent::runBare();
        } catch (Exception $e) {
            // cleanup after failed expectation
            phpunit_util::reset_all_data();
            throw $e;
        }

        if ($DB->is_transaction_started()) {
            phpunit_util::reset_all_data();
            throw new coding_exception('basic_testcase '.$this->getName().' is not supposed to use database transactions!');
        }

        phpunit_util::reset_all_data(true);
    }
}
