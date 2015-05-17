<?php


/**
 * Static unit tests
 *
 * @package    cache_stores
 * @subpackage static
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

// Include the necessary evils.
global $CFG;
require_once($CFG->dirroot.'/cache/tests/fixtures/stores.php');
require_once($CFG->dirroot.'/cache/stores/static/lib.php');

/**
 * Static unit test class.
 *
 */
class cachestore_static_test extends cachestore_tests {
    /**
     * Returns the static class name
     * @return string
     */
    protected function get_class_name() {
        return 'cachestore_static';
    }

    /**
     * Test the maxsize option.
     */
    public function test_maxsize() {
        $defid = 'phpunit/testmaxsize';
        $config = cache_config_testing::instance();
        $config->phpunit_add_definition($defid, array(
            'mode' => cache_store::MODE_REQUEST,
            'component' => 'phpunit',
            'area' => 'testmaxsize',
            'maxsize' => 3
        ));
        $definition = cache_definition::load($defid, $config->get_definition_by_id($defid));
        $instance = cachestore_static::initialise_test_instance($definition);

        $this->assertTrue($instance->set('key1', 'value1'));
        $this->assertTrue($instance->set('key2', 'value2'));
        $this->assertTrue($instance->set('key3', 'value3'));

        $this->assertTrue($instance->has('key1'));
        $this->assertTrue($instance->has('key2'));
        $this->assertTrue($instance->has('key3'));

        $this->assertTrue($instance->set('key4', 'value4'));
        $this->assertTrue($instance->set('key5', 'value5'));

        $this->assertFalse($instance->has('key1'));
        $this->assertFalse($instance->has('key2'));
        $this->assertTrue($instance->has('key3'));
        $this->assertTrue($instance->has('key4'));
        $this->assertTrue($instance->has('key5'));

        $this->assertFalse($instance->get('key1'));
        $this->assertFalse($instance->get('key2'));
        $this->assertEquals('value3', $instance->get('key3'));
        $this->assertEquals('value4', $instance->get('key4'));
        $this->assertEquals('value5', $instance->get('key5'));

        // Test adding one more.
        $this->assertTrue($instance->set('key6', 'value6'));
        $this->assertFalse($instance->get('key3'));

        // Test reducing and then adding to make sure we don't lost one.
        $this->assertTrue($instance->delete('key6'));
        $this->assertTrue($instance->set('key7', 'value7'));
        $this->assertEquals('value4', $instance->get('key4'));

        // Set the same key three times to make sure it doesn't count overrides.
        for ($i = 0; $i < 3; $i++) {
            $this->assertTrue($instance->set('key8', 'value8'));
        }

        $this->assertEquals('value7', $instance->get('key7'), 'Overrides are incorrectly incrementing size');

        // Test adding many.
        $this->assertEquals(3, $instance->set_many(array(
            array('key' => 'keyA', 'value' => 'valueA'),
            array('key' => 'keyB', 'value' => 'valueB'),
            array('key' => 'keyC', 'value' => 'valueC')
        )));
        $this->assertEquals(array(
            'key4' => false,
            'key5' => false,
            'key6' => false,
            'key7' => false,
            'keyA' => 'valueA',
            'keyB' => 'valueB',
            'keyC' => 'valueC'
        ), $instance->get_many(array(
            'key4', 'key5', 'key6', 'key7', 'keyA', 'keyB', 'keyC'
        )));
    }
}