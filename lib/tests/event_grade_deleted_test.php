<?php

/**
 * Tests the \core\event\grade_deleted event.
 *
 * @package    core
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Class core_event_grade_deleted_testcase
 *
 * Tests for event \core\event\grade_deleted
 *
 */
class core_event_grade_deleted_testcase extends advanced_testcase {

    /**
     * Tests the event details.
     */
    public function test_event() {
        global $CFG;
        require_once("$CFG->libdir/gradelib.php");

        $this->resetAfterTest();

        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_user();
        $quiz = $this->getDataGenerator()->create_module('quiz', array('course' => $course->id));

        // Create a grade item for the quiz.
        $grade = array();
        $grade['userid'] = $user->id;
        $grade['rawgrade'] = 50;
        grade_update('mod/quiz', $course->id, 'mod', 'quiz', $quiz->id, 0, $grade);

        // Get the grade item and override it.
        $gradeitem = grade_item::fetch(array('itemtype' => 'mod', 'itemmodule' => 'quiz', 'iteminstance' => $quiz->id,
            'courseid' => $course->id));
        $gradeitem->update_final_grade($user->id, 10, 'gradebook');

        // Get the grade_grade object.
        $gradegrade = new grade_grade(array('userid' => $user->id, 'itemid' => $gradeitem->id), true);
        $gradegrade->grade_item = $gradeitem;

        // Trigger the event.
        $sink = $this->redirectEvents();
        course_delete_module($quiz->cmid);
        $events = $sink->get_events();
        $event = reset($events);
        $sink->close();

        // Check the event details are correct.
        $grade = $event->get_grade();
        $this->assertInstanceOf('grade_grade', $grade);
        $this->assertInstanceOf('\core\event\grade_deleted', $event);
        $this->assertEquals(context_course::instance($course->id), $event->get_context());
        $this->assertSame($event->objecttable, 'grade_grades');
        $this->assertEquals($event->objectid, $gradegrade->id);
        $this->assertEquals($event->other['itemid'], $gradeitem->id);
        $this->assertTrue($event->other['overridden']);
        $this->assertEquals(10, $event->other['finalgrade']);
        $this->assertEventContextNotUsed($event);
        $this->assertEquals($gradegrade->id, $grade->id);
    }
}
