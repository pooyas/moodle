<?php

/**
 * MongoDB unit tests.
 *
 * If you wish to use these unit tests all you need to do is add the following definition to
 * your config.php file.
 *
 * define('TEST_CACHESTORE_MONGODB_TESTSERVER', 'mongodb://localhost:27017');
 *
 * @package    cachestore
 * @subpackage mongodb
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

// Include the necessary evils.
global $CFG;
require_once($CFG->dirroot.'/cache/tests/fixtures/stores.php');
require_once($CFG->dirroot.'/cache/stores/mongodb/lib.php');

/**
 * MongoDB unit test class.
 *
 * @package    cachestore_mongodb
 * @copyright  2015 Pooya Saeedi
 * 
 */
class cachestore_mongodb_test extends cachestore_tests {
    /**
     * Returns the MongoDB class name
     * @return string
     */
    protected function get_class_name() {
        return 'cachestore_mongodb';
    }

    /**
     * A small additional test to make sure definitions that hash a hash starting with a number work OK
     */
    public function test_collection_name() {
        // This generates a definition that has a hash starting with a number. MDL-46208.
        $definition = cache_definition::load_adhoc(cache_store::MODE_APPLICATION, 'cachestore_mongodb', 'abc');
        $instance = cachestore_mongodb::initialise_unit_test_instance($definition);

        if (!$instance) {
            $this->markTestSkipped();
        }

        $this->assertTrue($instance->set(1, 'alpha'));
        $this->assertTrue($instance->set(2, 'beta'));
        $this->assertEquals('alpha', $instance->get(1));
        $this->assertEquals('beta', $instance->get(2));
        $this->assertEquals(array(
            1 => 'alpha',
            2 => 'beta'
        ), $instance->get_many(array(1, 2)));
    }
}