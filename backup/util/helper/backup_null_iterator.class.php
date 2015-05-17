<?php



/**
 * @package    backup
 * @subpackage util
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Implementation of iterator interface to work without information
 *
 * This class implementes the iterator but does nothing (as far as it
 * doesn't handle real data at all). It's here to provide one common
 * API when we want to skip some elements from structure, while also
 * working with array/db iterators at the same time.
 *
 * TODO: Finish phpdocs
 */
class backup_null_iterator implements iterator {

    public function rewind() {
    }

    public function current() {
    }

    public function key() {
    }

    public function next() {
    }

    public function valid() {
        return false;
    }

    public function close() { // Added to provide compatibility with recordset iterators
    }
}
