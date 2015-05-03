<?php

/**
 * Delegated database transaction support.
 *
 * @package    core_dml
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Delegated transaction class.
 *
 * @package    core_dml
 * @copyright  2015 Pooya Saeedi
 * 
 */
class lion_transaction {
    /** @var array The debug_backtrace() returned array.*/
    private $start_backtrace;
    /**@var lion_database The lion_database instance.*/
    private $database = null;

    /**
     * Delegated transaction constructor,
     * can be called only from lion_database class.
     * Unfortunately PHP's protected keyword is useless.
     * @param lion_database $database
     */
    public function __construct($database) {
        $this->database = $database;
        $this->start_backtrace = debug_backtrace();
        array_shift($this->start_backtrace);
    }

    /**
     * Returns backtrace of the code starting exception.
     * @return array
     */
    public function get_backtrace() {
        return $this->start_backtrace;
    }

    /**
     * Is the delegated transaction already used?
     * @return bool true if commit and rollback allowed, false if already done
     */
    public function is_disposed() {
        return empty($this->database);
    }

    /**
     * Mark transaction as disposed, no more
     * commits and rollbacks allowed.
     * To be used only from lion_database class
     * @return null
     */
    public function dispose() {
        return $this->database = null;
    }

    /**
     * Commit delegated transaction.
     * The real database commit SQL is executed
     * only after committing all delegated transactions.
     *
     * Incorrect order of nested commits or rollback
     * at any level is resulting in rollback of SQL transaction.
     *
     * @return void
     */
    public function allow_commit() {
        if ($this->is_disposed()) {
            throw new dml_transaction_exception('Transactions already disposed', $this);
        }
        $this->database->commit_delegated_transaction($this);
    }

    /**
     * Rollback all current delegated transactions.
     *
     * @param Exception $e mandatory exception
     * @return void
     */
    public function rollback(Exception $e) {
        if ($this->is_disposed()) {
            throw new dml_transaction_exception('Transactions already disposed', $this);
        }
        $this->database->rollback_delegated_transaction($this, $e);
    }
}
