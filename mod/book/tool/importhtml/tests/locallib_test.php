<?php

/**
 * booktool_importhtml tests.
 *
 * @package    booktool_importhtml
 * @category   phpunit
 * @copyright  2013 Frédéric Massart
 * 
 */

defined('LION_INTERNAL') || die();
global $CFG;

require_once($CFG->dirroot.'/mod/book/tool/importhtml/locallib.php');

/**
 * booktool_importhtml tests class.
 *
 * @package    booktool_importhtml
 * @category   phpunit
 * @copyright  2013 Frédéric Massart
 * 
 */
class booktool_importhtml_locallib_testcase extends advanced_testcase {

    public function setUp() {
        $this->resetAfterTest();
    }

    public function test_import_chapters_events() {
        $course = $this->getDataGenerator()->create_course();
        $book = $this->getDataGenerator()->create_module('book', array('course' => $course->id));
        $context = context_module::instance($book->cmid);

        $record = new stdClass();
        $record->contextid = $context->id;
        $record->component = 'phpunit';
        $record->filearea = 'test';
        $record->itemid = 0;
        $record->filepath = '/';
        $record->filename = 'chapters.zip';

        $fs = get_file_storage();
        $file = $fs->create_file_from_pathname($record, __DIR__ . '/fixtures/chapters.zip');

        // Importing the chapters.
        $sink = $this->redirectEvents();
        toolbook_importhtml_import_chapters($file, 2, $book, $context, false);
        $events = $sink->get_events();

        // Checking the results.
        $this->assertCount(5, $events);
        foreach ($events as $event) {
            $this->assertInstanceOf('\mod_book\event\chapter_created', $event);
            $this->assertEquals($context, $event->get_context());
            $chapter = $event->get_record_snapshot('book_chapters', $event->objectid);
            $this->assertNotEmpty($chapter);
            $this->assertEventContextNotUsed($event);
        }
    }

}
