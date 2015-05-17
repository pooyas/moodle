<?php


/**
 * Events tests.
 *
 * @package    question
 * @subpackage tests
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/question/editlib.php');
require_once($CFG->dirroot . '/question/category_class.php');

class core_question_events_testcase extends advanced_testcase {

    /**
     * Tests set up.
     */
    public function setUp() {
        $this->resetAfterTest();
    }

    /**
     * Test the question category created event.
     */
    public function test_question_category_created() {
        $this->setAdminUser();
        $course = $this->getDataGenerator()->create_course();
        $quiz = $this->getDataGenerator()->create_module('quiz', array('course' => $course->id));

        $contexts = new question_edit_contexts(context_module::instance($quiz->cmid));

        $defaultcategoryobj = question_make_default_categories(array($contexts->lowest()));
        $defaultcategory = $defaultcategoryobj->id . ',' . $defaultcategoryobj->contextid;

        $qcobject = new question_category_object(
            1,
            new lion_url('/mod/quiz/edit.php', array('cmid' => $quiz->cmid)),
            $contexts->having_one_edit_tab_cap('categories'),
            $defaultcategoryobj->id,
            $defaultcategory,
            null,
            $contexts->having_cap('lion/question:add'));

        // Trigger and capture the event.
        $sink = $this->redirectEvents();
        $categoryid = $qcobject->add_category($defaultcategory, 'newcategory', '', true);
        $events = $sink->get_events();
        $event = reset($events);

        // Check that the event data is valid.
        $this->assertInstanceOf('\core\event\question_category_created', $event);
        $this->assertEquals(context_module::instance($quiz->cmid), $event->get_context());
        $expected = array($course->id, 'quiz', 'addcategory', 'view.php?id=' . $quiz->cmid , $categoryid, $quiz->cmid);
        $this->assertEventLegacyLogData($expected, $event);
        $this->assertEventContextNotUsed($event);
    }
}
