<?php

/**
 * Unit tests for the component and plugin definitions for availability system.
 *
 * @package core
 * @subpackage availability
 * @copyright 2015 Pooya Saeedi
 */

// Note:
// Renaming required

defined('MOODLE_INTERNAL') || die();

/**
 * Unit tests for the component and plugin definitions for availability system.
 *
 * @package core
 * @subpackage availability
 * @copyright 2015 Pooya Saeedi
 */
class core_availability_component_testcase extends advanced_testcase {
    /**
     * Tests loading a class from /availability/classes.
     */
    public function test_load_class() {
        $result = get_class_methods('\core_availability\info');
        $this->assertTrue(is_array($result));
    }

    /**
     * Tests the plugininfo class is present and working.
     */
    public function test_plugin_info() {
        // This code will throw debugging information if the plugininfo class
        // is missing. Unfortunately it doesn't actually cause the test to
        // fail, but it's obvious when running test at least.
        $pluginmanager = core_plugin_manager::instance();
        $list = $pluginmanager->get_enabled_plugins('availability');
        $this->assertEquals(array('completion', 'date', 'grade', 'group', 'grouping', 'profile'),
                array_keys($list));
    }
}
