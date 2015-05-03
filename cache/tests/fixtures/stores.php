<?php

/**
 * Cache store test fixtures.
 *
 * @package    core
 * @category   cache
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * An abstract class to make writing unit tests for cache stores very easy.
 *
 * @package    core
 * @category   cache
 * @copyright  2015 Pooya Saeedi
 * 
 */
abstract class cachestore_tests extends advanced_testcase {

    /**
     * Returns the class name for the store.
     *
     * @return string
     */
    abstract protected function get_class_name();

    /**
     * Run the unit tests for the store.
     */
    public function test_test_instance() {
        $class = $this->get_class_name();
        if (!class_exists($class) || !method_exists($class, 'initialise_test_instance') || !$class::are_requirements_met()) {
            $this->markTestSkipped('Could not test '.$class.'. Requirements are not met.');
        }

        $modes = $class::get_supported_modes();
        if ($modes & cache_store::MODE_APPLICATION) {
            $definition = cache_definition::load_adhoc(cache_store::MODE_APPLICATION, $class, 'phpunit_test');
            $instance = $class::initialise_unit_test_instance($definition);
            if (!$instance) {
                $this->markTestSkipped('Could not test '.$class.'. No test instance configured for application caches.');
            } else {
                $this->run_tests($instance);
            }
        }
        if ($modes & cache_store::MODE_SESSION) {
            $definition = cache_definition::load_adhoc(cache_store::MODE_SESSION, $class, 'phpunit_test');
            $instance = $class::initialise_unit_test_instance($definition);
            if (!$instance) {
                $this->markTestSkipped('Could not test '.$class.'. No test instance configured for session caches.');
            } else {
                $this->run_tests($instance);
            }
        }
        if ($modes & cache_store::MODE_REQUEST) {
            $definition = cache_definition::load_adhoc(cache_store::MODE_REQUEST, $class, 'phpunit_test');
            $instance = $class::initialise_unit_test_instance($definition);
            if (!$instance) {
                $this->markTestSkipped('Could not test '.$class.'. No test instance configured for request caches.');
            } else {
                $this->run_tests($instance);
            }
        }
    }

    /**
     * Test the store for basic functionality.
     */
    public function run_tests(cache_store $instance) {

        // Test set with a string.
        $this->assertTrue($instance->set('test1', 'test1'));
        $this->assertTrue($instance->set('test2', 'test2'));
        $this->assertTrue($instance->set('test3', '3'));

        // Test get with a string.
        $this->assertSame('test1', $instance->get('test1'));
        $this->assertSame('test2', $instance->get('test2'));
        $this->assertSame('3', $instance->get('test3'));

        // Test set with an int.
        $this->assertTrue($instance->set('test1', 1));
        $this->assertTrue($instance->set('test2', 2));

        // Test get with an int.
        $this->assertSame(1, $instance->get('test1'));
        $this->assertInternalType('int', $instance->get('test1'));
        $this->assertSame(2, $instance->get('test2'));
        $this->assertInternalType('int', $instance->get('test2'));

        // Test set with a bool.
        $this->assertTrue($instance->set('test1', true));

        // Test get with an bool.
        $this->assertSame(true, $instance->get('test1'));
        $this->assertInternalType('boolean', $instance->get('test1'));

        // Test delete.
        $this->assertTrue($instance->delete('test1'));
        $this->assertTrue($instance->delete('test3'));
        $this->assertFalse($instance->delete('test3'));
        $this->assertFalse($instance->get('test1'));
        $this->assertSame(2, $instance->get('test2'));
        $this->assertTrue($instance->set('test1', 'test1'));

        // Test purge.
        $this->assertTrue($instance->purge());
        $this->assertFalse($instance->get('test1'));
        $this->assertFalse($instance->get('test2'));

        // Test set_many.
        $outcome = $instance->set_many(array(
            array('key' => 'many1', 'value' => 'many1'),
            array('key' => 'many2', 'value' => 'many2'),
            array('key' => 'many3', 'value' => 'many3'),
            array('key' => 'many4', 'value' => 'many4'),
            array('key' => 'many5', 'value' => 'many5')
        ));
        $this->assertSame(5, $outcome);
        $this->assertSame('many1', $instance->get('many1'));
        $this->assertSame('many5', $instance->get('many5'));
        $this->assertFalse($instance->get('many6'));

        // Test get_many.
        $result = $instance->get_many(array('many1', 'many3', 'many5', 'many6'));
        $this->assertInternalType('array', $result);
        $this->assertCount(4, $result);
        $this->assertSame(array(
            'many1' => 'many1',
            'many3' => 'many3',
            'many5' => 'many5',
            'many6' => false,
        ), $result);

        // Test delete_many.
        $this->assertSame(3, $instance->delete_many(array('many2', 'many3', 'many4')));
        $this->assertSame(2, $instance->delete_many(array('many1', 'many5', 'many6')));
    }
}