<?php

/**
 * File unit tests
 *
 * @package    cachestore_file
 * @copyright  2013 Sam Hemelryk
 * 
 */

defined('LION_INTERNAL') || die();

// Include the necessary evils.
global $CFG;
require_once($CFG->dirroot.'/cache/tests/fixtures/stores.php');
require_once($CFG->dirroot.'/cache/stores/file/lib.php');

/**
 * File unit test class.
 *
 * @package    cachestore_file
 * @copyright  2013 Sam Hemelryk
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