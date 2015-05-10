<?php

/**
 * Events tests.
 *
 * @package    assignsubmission
 * @subpackage comments
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/mod/assign/lib.php');
require_once($CFG->dirroot . '/mod/assign/locallib.php');
require_once($CFG->dirroot . '/mod/assign/tests/base_test.php');

/**
 * Events tests class.
 *
 */
class assignsubmission_comments_events_testcase extends mod_assign_base_testcase {

    /**
     * Test comment_created event.
     */
    public function test_comment_created() {
        global $CFG;
        require_once($CFG->dirroot . '/comment/lib.php');

        $this->setUser($this->editingteachers[0]);
        $assign = $this->create_instance();
        $submission = $assign->get_user_submission($this->students[0]->id, true);

        $context = $assign->get_context();
        $options = new stdClass();
        $options->area = 'submission_comments';
        $options->course = $assign->get_course();
        $options->context = $context;
        $options->itemid = $submission->id;
        $options->component = 'assignsubmission_comments';
        $options->showcount = true;
        $options->displaycancel = true;

        $comment = new comment($options);

        // Triggering and capturing the event.
        $sink = $this->redirectEvents();
        $comment->add('New comment');
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = reset($events);

        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\assignsubmission_comments\event\comment_created', $event);
        $this->assertEquals($context, $event->get_context());
        $url = new lion_url('/mod/assign/view.php', array('id' => $assign->get_course_module()->id));
        $this->assertEquals($url, $event->get_url());
        $this->assertEventContextNotUsed($event);
    }

    /**
     * Test comment_deleted event.
     */
    public function test_comment_deleted() {
        global $CFG;
        require_once($CFG->dirroot . '/comment/lib.php');

        $this->setUser($this->editingteachers[0]);
        $assign = $this->create_instance();
        $submission = $assign->get_user_submission($this->students[0]->id, true);

        $context = $assign->get_context();
        $options = new stdClass();
        $options->area    = 'submission_comments';
        $options->course    = $assign->get_course();
        $options->context = $context;
        $options->itemid  = $submission->id;
        $options->component = 'assignsubmission_comments';
        $options->showcount = true;
        $options->displaycancel = true;
        $comment = new comment($options);
        $newcomment = $comment->add('New comment 1');

        // Triggering and capturing the event.
        $sink = $this->redirectEvents();
        $comment->delete($newcomment->id);
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = reset($events);

        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\assignsubmission_comments\event\comment_deleted', $event);
        $this->assertEquals($context, $event->get_context());
        $url = new lion_url('/mod/assign/view.php', array('id' => $assign->get_course_module()->id));
        $this->assertEquals($url, $event->get_url());
        $this->assertEventContextNotUsed($event);
    }
}
