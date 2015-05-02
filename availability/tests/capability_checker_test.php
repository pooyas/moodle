<?php

/**
 * Unit tests for the capability checker class.
 *
 * @package core_availability
 * @copyright 2014 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core_availability\capability_checker;

defined('LION_INTERNAL') || die();

/**
 * Unit tests for the capability checker class.
 *
 * @package core_availability
 * @copyright 2014 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_availability_capability_checker_testcase extends advanced_testcase {
    /**
     * Tests loading a class from /availability/classes.
     */
    public function test_capability_checker() {
        global $CFG, $DB;
        $this->resetAfterTest();

        // Create a course with teacher and student.
        $generator = $this->getDataGenerator();
        $course = $generator->create_course();
        $roleids = $DB->get_records_menu('role', null, '', 'shortname, id');
        $teacher = $generator->create_user();
        $student = $generator->create_user();
        $generator->enrol_user($teacher->id, $course->id, $roleids['teacher']);
        $generator->enrol_user($student->id, $course->id, $roleids['student']);

        // Check a capability which they both have.
        $context = context_course::instance($course->id);
        $checker = new capability_checker($context);
        $result = array_keys($checker->get_users_by_capability('mod/forum:replypost'));
        sort($result);
        $this->assertEquals(array($teacher->id, $student->id), $result);

        // And one that only teachers have.
        $result = array_keys($checker->get_users_by_capability('mod/forum:deleteanypost'));
        $this->assertEquals(array($teacher->id), $result);

        // Check the caching is working.
        $before = $DB->perf_get_queries();
        $result = array_keys($checker->get_users_by_capability('mod/forum:deleteanypost'));
        $this->assertEquals(array($teacher->id), $result);
        $this->assertEquals($before, $DB->perf_get_queries());
    }
}
