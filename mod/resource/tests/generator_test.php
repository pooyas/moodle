<?php


/**
 * PHPUnit data generator tests.
 *
 * @category phpunit
 * @package    mod
 * @subpackage resource
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();


/**
 * PHPUnit data generator testcase.
 *
 * @category phpunit
 */
class mod_resource_generator_testcase extends advanced_testcase {
    public function test_generator() {
        global $DB, $SITE;

        $this->resetAfterTest(true);

        // Must be a non-guest user to create resources.
        $this->setAdminUser();

        // There are 0 resources initially.
        $this->assertEquals(0, $DB->count_records('resource'));

        // Create the generator object and do standard checks.
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_resource');
        $this->assertInstanceOf('mod_resource_generator', $generator);
        $this->assertEquals('resource', $generator->get_modulename());

        // Create three instances in the site course.
        $generator->create_instance(array('course' => $SITE->id));
        $generator->create_instance(array('course' => $SITE->id));
        $resource = $generator->create_instance(array('course' => $SITE->id));
        $this->assertEquals(3, $DB->count_records('resource'));

        // Check the course-module is correct.
        $cm = get_coursemodule_from_instance('resource', $resource->id);
        $this->assertEquals($resource->id, $cm->instance);
        $this->assertEquals('resource', $cm->modname);
        $this->assertEquals($SITE->id, $cm->course);

        // Check the context is correct.
        $context = context_module::instance($cm->id);
        $this->assertEquals($resource->cmid, $context->instanceid);

        // Check that generated resource module contains a file.
        $fs = get_file_storage();
        $files = $fs->get_area_files($context->id, 'mod_resource', 'content', false, '', false);
        $this->assertEquals(1, count($files));
    }
}
