<?php

/**
 * Events tests.
 *
 * @package    block_comments
 * @category   test
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Events tests class.
 *
 * @package    block_comments
 * @category   test
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */
class block_comments_events_testcase extends advanced_testcase {
    /** @var stdClass Keeps course object */
    private $course;

    /** @var stdClass Keeps wiki object */
    private $wiki;

    /**
     * Setup test data.
     */
    public function setUp() {
        $this->resetAfterTest();
        $this->setAdminUser();

        // Create course and wiki.
        $this->course = $this->getDataGenerator()->create_course();
        $this->wiki = $this->getDataGenerator()->create_module('wiki', array('course' => $this->course->id));
    }

    /**
     * Test comment_created event.
     */
    public function test_comment_created() {
        global $CFG;

        require_once($CFG->dirroot . '/comment/lib.php');

        // Comment on course page.
        $context = context_course::instance($this->course->id);
        $args = new stdClass;
        $args->context = $context;
        $args->course = $this->course;
        $args->area = 'page_comments';
        $args->itemid = 0;
        $args->component = 'block_comments';
        $args->linktext = get_string('showcomments');
        $args->notoggle = true;
        $args->autostart = true;
        $args->displaycancel = false;
        $comment = new comment($args);

        // Triggering and capturing the event.
        $sink = $this->redirectEvents();
        $comment->add('New comment');
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = reset($events);

        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\block_comments\event\comment_created', $event);
        $this->assertEquals($context, $event->get_context());
        $url = new lion_url('/course/view.php', array('id' => $this->course->id));
        $this->assertEquals($url, $event->get_url());

        // Comments when block is on module (wiki) page.
        $context = context_module::instance($this->wiki->cmid);
        $args = new stdClass;
        $args->context   = $context;
        $args->course    = $this->course;
        $args->area      = 'page_comments';
        $args->itemid    = 0;
        $args->component = 'block_comments';
        $args->linktext  = get_string('showcomments');
        $args->notoggle  = true;
        $args->autostart = true;
        $args->displaycancel = false;
        $comment = new comment($args);

        // Triggering and capturing the event.
        $sink = $this->redirectEvents();
        $comment->add('New comment 1');
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = reset($events);

        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\block_comments\event\comment_created', $event);
        $this->assertEquals($context, $event->get_context());
        $url = new lion_url('/mod/wiki/view.php', array('id' => $this->wiki->cmid));
        $this->assertEquals($url, $event->get_url());
        $this->assertEventContextNotUsed($event);
    }

    /**
     * Test comment_deleted event.
     */
    public function test_comment_deleted() {
        global $CFG;

        require_once($CFG->dirroot . '/comment/lib.php');

        // Comment on course page.
        $context = context_course::instance($this->course->id);
        $args = new stdClass;
        $args->context   = $context;
        $args->course    = $this->course;
        $args->area      = 'page_comments';
        $args->itemid    = 0;
        $args->component = 'block_comments';
        $args->linktext  = get_string('showcomments');
        $args->notoggle  = true;
        $args->autostart = true;
        $args->displaycancel = false;
        $comment = new comment($args);
        $newcomment = $comment->add('New comment');

        // Triggering and capturing the event.
        $sink = $this->redirectEvents();
        $comment->delete($newcomment->id);
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = reset($events);

        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\block_comments\event\comment_deleted', $event);
        $this->assertEquals($context, $event->get_context());
        $url = new lion_url('/course/view.php', array('id' => $this->course->id));
        $this->assertEquals($url, $event->get_url());

        // Comments when block is on module (wiki) page.
        $context = context_module::instance($this->wiki->cmid);
        $args = new stdClass;
        $args->context   = $context;
        $args->course    = $this->course;
        $args->area      = 'page_comments';
        $args->itemid    = 0;
        $args->component = 'block_comments';
        $args->linktext  = get_string('showcomments');
        $args->notoggle  = true;
        $args->autostart = true;
        $args->displaycancel = false;
        $comment = new comment($args);
        $newcomment = $comment->add('New comment 1');

        // Triggering and capturing the event.
        $sink = $this->redirectEvents();
        $comment->delete($newcomment->id);
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = reset($events);

        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\block_comments\event\comment_deleted', $event);
        $this->assertEquals($context, $event->get_context());
        $url = new lion_url('/mod/wiki/view.php', array('id' => $this->wiki->cmid));
        $this->assertEquals($url, $event->get_url());
        $this->assertEventContextNotUsed($event);
    }
}
