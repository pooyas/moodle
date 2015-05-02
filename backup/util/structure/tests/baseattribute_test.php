<?php

/**
 * @package   core_backup
 * @category  phpunit
 * @copyright 2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 */

defined('LION_INTERNAL') || die();

// Include all the needed stuff
require_once(__DIR__.'/fixtures/structure_fixtures.php');


/**
 * Unit test case the base_attribute class. Note: No really much to test here as attribute is 100%
 * atom extension without new functionality (name/value)
 */
class backup_base_attribute_testcase extends basic_testcase {

    /**
     * Correct base_attribute tests
     */
    function test_base_attribute() {
        $name_with_all_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_';
        $value_to_test = 'Some <value> to test';

        // Create instance with correct names
        $instance = new mock_base_attribute($name_with_all_chars);
        $this->assertInstanceOf('base_attribute', $instance);
        $this->assertEquals($instance->get_name(), $name_with_all_chars);
        $this->assertNull($instance->get_value());

        // Set value
        $instance->set_value($value_to_test);
        $this->assertEquals($instance->get_value(), $value_to_test);

        // Get to_string() results (with values)
        $instance = new mock_base_attribute($name_with_all_chars);
        $instance->set_value($value_to_test);
        $tostring = $instance->to_string(true);
        $this->assertTrue(strpos($tostring, '@' . $name_with_all_chars) !== false);
        $this->assertTrue(strpos($tostring, ' => ') !== false);
        $this->assertTrue(strpos($tostring, $value_to_test) !== false);
    }
}
