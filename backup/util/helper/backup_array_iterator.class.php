<?php


/**
 * @package    core
 * @subpackage backup-helper
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Implementation of iterator interface to work with common arrays
 *
 * This class implements the iterator interface in order to provide one
 * common API to be used in backup and restore when, within the same code,
 * both database recordsets (already iteratorors) and arrays of information
 * are used.
 *
 * TODO: Finish phpdocs
 */
class backup_array_iterator implements iterator {

    private $arr;

    public function __construct(array $arr) {
        $this->arr = $arr;
    }

    public function rewind() {
        return reset($this->arr);
    }

    public function current() {
        return current($this->arr);
    }

    public function key() {
        return key($this->arr);
    }

    public function next() {
        return next($this->arr);
    }

    public function valid() {
        return key($this->arr) !== null;
    }

    public function close() { // Added to provide compatibility with recordset iterators
        reset($this->arr); // Just reset the array
    }
}
