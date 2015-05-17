<?php


/**
 * Events tests.
 *
 * @category   phpunit
 * @package    mod
 * @subpackage book
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();
global $CFG;

/**
 * Events tests class.
 *
 * @category   phpunit
 */
class booktool_print_events_testcase extends advanced_testcase {

    public function setUp() {
        $this->resetAfterTest();
    }

    public function test_book_printed() {
        // There is no proper API to call to test the event, so what we are
        // doing here is simply making sure that the events returns the right information.

        $course = $this->getDataGenerator()->create_course();
        $book = $this->getDataGenerator()->create_module('book', array('course' => $course->id));
        $context = context_module::instance($book->cmid);

        $event = \booktool_print\event\book_printed::create_from_book($book, $context);

        // Triggering and capturing the event.
        $sink = $this->redirectEvents();
        $event->trigger();
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = reset($events);

        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\booktool_print\event\book_printed', $event);
        $this->assertEquals(context_module::instance($book->cmid), $event->get_context());
        $this->assertEquals($book->id, $event->objectid);
        $expected = array($course->id, 'book',  'print', 'tool/print/index.php?id=' . $book->cmid, $book->id, $book->cmid);
        $this->assertEventLegacyLogData($expected, $event);
        $this->assertEventContextNotUsed($event);
    }


    public function test_chapter_printed() {
        // There is no proper API to call to test the event, so what we are
        // doing here is simply making sure that the events returns the right information.

        $course = $this->getDataGenerator()->create_course();
        $book = $this->getDataGenerator()->create_module('book', array('course' => $course->id));
        $bookgenerator = $this->getDataGenerator()->get_plugin_generator('mod_book');
        $chapter = $bookgenerator->create_chapter(array('bookid' => $book->id));
        $context = context_module::instance($book->cmid);

        $event = \booktool_print\event\chapter_printed::create_from_chapter($book, $context, $chapter);

        // Triggering and capturing the event.
        $sink = $this->redirectEvents();
        $event->trigger();
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = reset($events);

        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\booktool_print\event\chapter_printed', $event);
        $this->assertEquals(context_module::instance($book->cmid), $event->get_context());
        $this->assertEquals($chapter->id, $event->objectid);
        $expected = array($course->id, 'book', 'print chapter', 'tool/print/index.php?id=' . $book->cmid .
            '&chapterid=' . $chapter->id, $chapter->id, $book->cmid);
        $this->assertEventLegacyLogData($expected, $event);
        $this->assertEventContextNotUsed($event);
    }

}
