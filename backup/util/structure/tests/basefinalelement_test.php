<?php

/**
 * @package   core
 * @subpackage backup
 * @category  phpunit
 * @copyright 2015 Pooya Saeedi
 */

// Note:
// Renaming required

defined('MOODLE_INTERNAL') || die();

// Include all the needed stuff
require_once(__DIR__.'/fixtures/structure_fixtures.php');


/**
 * Unit test case the base_final_element class. Note: highly imbricated with base_nested_element class
 */
class backup_base_final_element_testcase extends basic_testcase {

    /**
     * Correct base_final_element tests
     */
    function test_base_final_element() {

        // Create instance with name
        $instance = new mock_base_final_element('TEST');
        $this->assertInstanceOf('base_final_element', $instance);
        $this->assertEquals($instance->get_name(), 'TEST');
        $this->assertNull($instance->get_value());
        $this->assertEquals($instance->get_attributes(), array());
        $this->assertNull($instance->get_parent());
        $this->assertEquals($instance->get_level(), 1);

        // Set value
        $instance->set_value('value');
        $this->assertEquals($instance->get_value(), 'value');

        // Create instance with name and one object attribute
        $instance = new mock_base_final_element('TEST', new mock_base_attribute('ATTR1'));
        $attrs = $instance->get_attributes();
        $this->assertTrue(is_array($attrs));
        $this->assertEquals(count($attrs), 1);
        $this->assertTrue($attrs['ATTR1'] instanceof base_attribute);
        $this->assertEquals($attrs['ATTR1']->get_name(), 'ATTR1');
        $this->assertNull($attrs['ATTR1']->get_value());

        // Create instance with name and various object attributes
        $attr1 = new mock_base_attribute('ATTR1');
        $attr1->set_value('attr1_value');
        $attr2 = new mock_base_attribute('ATTR2');
        $instance = new mock_base_final_element('TEST', array($attr1, $attr2));
        $attrs = $instance->get_attributes();
        $this->assertTrue(is_array($attrs));
        $this->assertEquals(count($attrs), 2);
        $this->assertTrue($attrs['ATTR1'] instanceof base_attribute);
        $this->assertEquals($attrs['ATTR1']->get_name(), 'ATTR1');
        $this->assertEquals($attrs['ATTR1']->get_value(), 'attr1_value');
        $this->assertTrue($attrs['ATTR2'] instanceof base_attribute);
        $this->assertEquals($attrs['ATTR2']->get_name(), 'ATTR2');
        $this->assertNull($attrs['ATTR2']->get_value());

        // Create instance with name and one string attribute
        $instance = new mock_base_final_element('TEST', 'ATTR1');
        $attrs = $instance->get_attributes();
        $this->assertTrue(is_array($attrs));
        $this->assertEquals(count($attrs), 1);
        $this->assertTrue($attrs['ATTR1'] instanceof base_attribute);
        $this->assertEquals($attrs['ATTR1']->get_name(), 'ATTR1');
        $this->assertNull($attrs['ATTR1']->get_value());

        // Create instance with name and various object attributes
        $instance = new mock_base_final_element('TEST', array('ATTR1', 'ATTR2'));
        $attrs = $instance->get_attributes();
        $attrs['ATTR1']->set_value('attr1_value');
        $this->assertTrue(is_array($attrs));
        $this->assertEquals(count($attrs), 2);
        $this->assertTrue($attrs['ATTR1'] instanceof base_attribute);
        $this->assertEquals($attrs['ATTR1']->get_name(), 'ATTR1');
        $this->assertEquals($attrs['ATTR1']->get_value(), 'attr1_value');
        $this->assertTrue($attrs['ATTR2'] instanceof base_attribute);
        $this->assertEquals($attrs['ATTR2']->get_name(), 'ATTR2');
        $this->assertNull($attrs['ATTR2']->get_value());

        // Clean values
        $instance = new mock_base_final_element('TEST', array('ATTR1', 'ATTR2'));
        $instance->set_value('instance_value');
        $attrs = $instance->get_attributes();
        $attrs['ATTR1']->set_value('attr1_value');
        $this->assertEquals($instance->get_value(), 'instance_value');
        $this->assertEquals($attrs['ATTR1']->get_value(), 'attr1_value');
        $instance->clean_values();
        $this->assertNull($instance->get_value());
        $this->assertNull($attrs['ATTR1']->get_value());

        // Get to_string() results (with values)
        $instance = new mock_base_final_element('TEST', array('ATTR1', 'ATTR2'));
        $instance->set_value('final element value');
        $attrs = $instance->get_attributes();
        $attrs['ATTR1']->set_value('attr1 value');
        $tostring = $instance->to_string(true);
        $this->assertTrue(strpos($tostring, '#TEST (level: 1)') !== false);
        $this->assertTrue(strpos($tostring, ' => ') !== false);
        $this->assertTrue(strpos($tostring, 'final element value') !== false);
        $this->assertTrue(strpos($tostring, 'attr1 value') !== false);
    }

    /**
     * Exception base_final_element tests
     */
    function test_base_final_element_exceptions() {

        // Create instance with invalid name
        try {
            $instance = new mock_base_final_element('');
            $this->fail("Expecting base_atom_struct_exception exception, none occurred");
        } catch (Exception $e) {
            $this->assertTrue($e instanceof base_atom_struct_exception);
        }

        // Create instance with incorrect (object) attribute
        try {
            $obj = new stdClass;
            $obj->name = 'test_attr';
            $instance = new mock_base_final_element('TEST', $obj);
            $this->fail("Expecting base_element_attribute_exception exception, none occurred");
        } catch (Exception $e) {
            $this->assertTrue($e instanceof base_element_attribute_exception);
        }

        // Create instance with array containing incorrect (object) attribute
        try {
            $obj = new stdClass;
            $obj->name = 'test_attr';
            $instance = new mock_base_final_element('TEST', array($obj));
            $this->fail("Expecting base_element_attribute_exception exception, none occurred");
        } catch (Exception $e) {
            $this->assertTrue($e instanceof base_element_attribute_exception);
        }

        // Create instance with array containing duplicate attributes
        try {
            $instance = new mock_base_final_element('TEST', array('ATTR1', 'ATTR2', 'ATTR1'));
            $this->fail("Expecting base_element_attribute_exception exception, none occurred");
        } catch (Exception $e) {
            $this->assertTrue($e instanceof base_element_attribute_exception);
        }
    }
}
