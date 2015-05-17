<?php


/**
 * format_topics related unit tests
 *
 * @package    course_format
 * @subpackage topics
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/course/lib.php');

/**
 * format_topics related unit tests
 *
 */
class format_topics_testcase extends advanced_testcase {

    public function test_update_course_numsections() {
        global $DB;
        $this->resetAfterTest(true);

        $generator = $this->getDataGenerator();

        $course = $generator->create_course(array('numsections' => 10, 'format' => 'topics'),
            array('createsections' => true));
        $generator->create_module('assign', array('course' => $course, 'section' => 7));

        $this->setAdminUser();

        $this->assertEquals(11, $DB->count_records('course_sections', array('course' => $course->id)));

        // Change the numsections to 8, last two sections did not have any activities, they should be deleted.
        update_course((object)array('id' => $course->id, 'numsections' => 8));
        $this->assertEquals(9, $DB->count_records('course_sections', array('course' => $course->id)));
        $this->assertEquals(9, count(get_fast_modinfo($course)->get_section_info_all()));

        // Change the numsections to 5, section 8 should be deleted but section 7 should remain as it has activities.
        update_course((object)array('id' => $course->id, 'numsections' => 6));
        $this->assertEquals(8, $DB->count_records('course_sections', array('course' => $course->id)));
        $this->assertEquals(8, count(get_fast_modinfo($course)->get_section_info_all()));
        $this->assertEquals(6, course_get_format($course)->get_course()->numsections);
    }
}
