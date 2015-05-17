<?php


/**
 * File unit tests
 *
 * @package    cache_stores
 * @subpackage file
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

// Include the necessary evils.
global $CFG;
require_once($CFG->dirroot.'/cache/tests/fixtures/stores.php');
require_once($CFG->dirroot.'/cache/stores/file/lib.php');

/**
 * File unit test class.
 *
 */
class cachestore_file_test extends cachestore_tests {
    /**
     * Returns the file class name
     * @return string
     */
    protected function get_class_name() {
        return 'cachestore_file';
    }
}