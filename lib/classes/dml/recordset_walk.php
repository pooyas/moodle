<?php

/**
 * Applies the same callback to all recorset records.
 *
 * @package    core
 * @subpackage dml
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\dml;

defined('LION_INTERNAL') || die();

/**
 * Iterator that walks through a lion_recordset applying the provided function.
 *
 * The internal recordset can be closed using the close() function.
 *
 * Note that consumers of this class are responsible of closing the recordset,
 * although there are some implicit closes under some ciscumstances:
 * - Once all recordset records have been iterated
 * - The object is destroyed
 *
 * 
 */
class recordset_walk implements \Iterator {

    /**
     * @var \lion_recordset The recordset.
     */
    protected $recordset;

    /**
     * @var callable The callback.
     */
    protected $callback;

    /**
     * @var array|false Extra params for the callback.
     */
    protected $callbackextra;

    /**
     * Create a new iterator applying the callback to each record.
     *
     * @param \lion_recordset $recordset Recordset to iterate.
     * @param callable $callback Apply this function to each record. If using a method, it should be public.
     * @param array $callbackextra Array of arguments to pass to the callback.
     */
    public function __construct(\lion_recordset $recordset, callable $callback, $callbackextra = false) {
        $this->recordset = $recordset;
        $this->callback = $callback;
        $this->callbackextra = $callbackextra;
    }

    /**
     * Closes the recordset.
     *
     * @return void
     */
    public function __destruct() {
        $this->close();
    }

    /**
     * Returns the current element after applying the callback.
     *
     * @return mixed|bool The returned value type will depend on the callback.
     */
    public function current() {

        if (!$this->recordset->valid()) {
            return false;
        }

        if (!$record = $this->recordset->current()) {
            return false;
        }

        // Apply callback and return.
        if ($this->callbackextra) {
            return call_user_func($this->callback, $record);
        } else {
            return call_user_func($this->callback, $record, $this->callbackextra);
        }
    }

    /**
     * Moves the internal pointer to the next record.
     *
     * @return void
     */
    public function next() {
        return $this->recordset->next();
    }

    /**
     * Returns current record key.
     *
     * @return int
     */
    public function key() {
        return $this->recordset->key();
    }

    /**
     * Returns whether the current position is valid or not.
     *
     * If we reached the end of the recordset we close as we
     * don't allow rewinds. Doing do so we reduce the chance
     * of unclosed recordsets.
     *
     * @return bool
     */
    public function valid() {
        if (!$valid = $this->recordset->valid()) {
            $this->close();
        }
        return $valid;
    }

    /**
     * Rewind is not supported.
     *
     * @return void
     */
    public function rewind() {
        // No rewind as it is not implemented in lion_recordset.
        return;
    }

    /**
     * Closes the recordset.
     *
     * @return void
     */
    public function close() {
        $this->recordset->close();
    }
}
