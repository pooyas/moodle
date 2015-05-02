<?php

/**
 * Course related unit tests
 *
 * @package    core_course
 * @copyright  2014 Marina Glancy
 * 
 */

defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/tests/fixtures/format_theunittest.php');

class core_course_courseformat_testcase extends advanced_testcase {
    public function test_available_hook() {
        global $DB;
        $this->resetAfterTest();

        // Generate a course with two sections (0 and 1) and two modules. Course format is set to 'theunittest'.
        $generator = $this->getDataGenerator();
        $course1 = $generator->create_course(array('format' => 'theunittest'));
        $this->assertEquals('theunittest', $course1->format);
        course_create_sections_if_missing($course1, array(0, 1));
        $assign0 = $generator->create_module('assign', array('course' => $course1, 'section' => 0));
        $assign1 = $generator->create_module('assign', array('course' => $course1, 'section' => 1));

        // Enrol student and teacher.
        $roleids = $DB->get_records_menu('role', null, '', 'shortname, id');
        $student = $generator->create_user();
        $generator->enrol_user($student->id, $course1->id, $roleids['student']);
        $teacher = $generator->create_user();
        $generator->enrol_user($teacher->id, $course1->id, $roleids['editingteacher']);

        // Make sure that initially both sections and both modules are available and visible for a student.
        $modinfostudent = get_fast_modinfo($course1, $student->id);
        $this->assertTrue($modinfostudent->get_section_info(1)->available);
        $this->assertTrue($modinfostudent->get_cm($assign0->cmid)->available);
        $this->assertTrue($modinfostudent->get_cm($assign0->cmid)->uservisible);
        $this->assertTrue($modinfostudent->get_cm($assign1->cmid)->available);
        $this->assertTrue($modinfostudent->get_cm($assign1->cmid)->uservisible);

        // Set 'hideoddsections' for the course to 1.
        // Section1 and assign1 will be unavailable, uservisible will be false for student and true for teacher.
        $data = (object)array('id' => $course1->id, 'hideoddsections' => 1);
        course_get_format($course1)->update_course_format_options($data);
        $modinfostudent = get_fast_modinfo($course1, $student->id);
        $this->assertFalse($modinfostudent->get_section_info(1)->available);
        $this->assertEmpty($modinfostudent->get_section_info(1)->availableinfo);
        $this->assertFalse($modinfostudent->get_section_info(1)->uservisible);
        $this->assertTrue($modinfostudent->get_cm($assign0->cmid)->available);
        $this->assertTrue($modinfostudent->get_cm($assign0->cmid)->uservisible);
        $this->assertFalse($modinfostudent->get_cm($assign1->cmid)->available);
        $this->assertFalse($modinfostudent->get_cm($assign1->cmid)->uservisible);

        $modinfoteacher = get_fast_modinfo($course1, $teacher->id);
        $this->assertFalse($modinfoteacher->get_section_info(1)->available);
        $this->assertEmpty($modinfoteacher->get_section_info(1)->availableinfo);
        $this->assertTrue($modinfoteacher->get_section_info(1)->uservisible);
        $this->assertTrue($modinfoteacher->get_cm($assign0->cmid)->available);
        $this->assertTrue($modinfoteacher->get_cm($assign0->cmid)->uservisible);
        $this->assertFalse($modinfoteacher->get_cm($assign1->cmid)->available);
        $this->assertTrue($modinfoteacher->get_cm($assign1->cmid)->uservisible);

        // Set 'hideoddsections' for the course to 2.
        // Section1 and assign1 will be unavailable, uservisible will be false for student and true for teacher.
        // Property availableinfo will be not empty.
        $data = (object)array('id' => $course1->id, 'hideoddsections' => 2);
        course_get_format($course1)->update_course_format_options($data);
        $modinfostudent = get_fast_modinfo($course1, $student->id);
        $this->assertFalse($modinfostudent->get_section_info(1)->available);
        $this->assertNotEmpty($modinfostudent->get_section_info(1)->availableinfo);
        $this->assertFalse($modinfostudent->get_section_info(1)->uservisible);
        $this->assertTrue($modinfostudent->get_cm($assign0->cmid)->available);
        $this->assertTrue($modinfostudent->get_cm($assign0->cmid)->uservisible);
        $this->assertFalse($modinfostudent->get_cm($assign1->cmid)->available);
        $this->assertFalse($modinfostudent->get_cm($assign1->cmid)->uservisible);

        $modinfoteacher = get_fast_modinfo($course1, $teacher->id);
        $this->assertFalse($modinfoteacher->get_section_info(1)->available);
        $this->assertNotEmpty($modinfoteacher->get_section_info(1)->availableinfo);
        $this->assertTrue($modinfoteacher->get_section_info(1)->uservisible);
        $this->assertTrue($modinfoteacher->get_cm($assign0->cmid)->available);
        $this->assertTrue($modinfoteacher->get_cm($assign0->cmid)->uservisible);
        $this->assertFalse($modinfoteacher->get_cm($assign1->cmid)->available);
        $this->assertTrue($modinfoteacher->get_cm($assign1->cmid)->uservisible);
    }
}
