<?php

/**
 * Unit test for the site generator
 *
 * @package tool_generator
 * @copyright 2013 David Monllaó
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('LION_INTERNAL') || die();

/**
 * Silly class to access site_backend internal methods.
 *
 * @package tool_generator
 * @copyright 2013 David Monllaó
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class testable_tool_generator_site_backend extends tool_generator_site_backend {

    /**
     * Public accessor.
     *
     * @return int
     */
    public static function get_last_testcourse_id() {
        return parent::get_last_testcourse_id();
    }
}

/**
 * Unit test for the site generator
 *
 * @package tool_generator
 * @copyright 2013 David Monllaó
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_generator_maketestsite_testcase extends advanced_testcase {

    /**
     * Checks that site courses shortnames are properly generated.
     */
    public function test_shortnames_generation() {

        $this->resetAfterTest();
        $this->setAdminUser();

        $generator = $this->getDataGenerator();

        // Shortname common prefix.
        $prefix = tool_generator_site_backend::SHORTNAMEPREFIX;

        $record = array();

        // Without courses will be 0.
        $lastshortname = testable_tool_generator_site_backend::get_last_testcourse_id();
        $this->assertEquals(0, $lastshortname);

        // Without {$prefix} + {no integer} courses will be 0.
        $record['shortname'] = $prefix . 'AA';
        $generator->create_course($record);
        $record['shortname'] = $prefix . '__';
        $generator->create_course($record);
        $record['shortname'] = $prefix . '12.2';
        $generator->create_course($record);

        $lastshortname = testable_tool_generator_site_backend::get_last_testcourse_id();
        $this->assertEquals(0, $lastshortname);

        // With {$prefix} + {integer} courses will be the higher one.
        $record['shortname'] = $prefix . '2';
        $generator->create_course($record);
        $record['shortname'] = $prefix . '20';
        $generator->create_course($record);
        $record['shortname'] = $prefix . '8';
        $generator->create_course($record);

        $lastshortname = testable_tool_generator_site_backend::get_last_testcourse_id();
        $this->assertEquals(20, $lastshortname);

        // Numeric order.
        for ($i = 9; $i < 14; $i++) {
            $record['shortname'] = $prefix . $i;
            $generator->create_course($record);
        }

        $lastshortname = testable_tool_generator_site_backend::get_last_testcourse_id();
        $this->assertEquals(20, $lastshortname);
    }

}
