<?php

/**
 * Events tests.
 *
 * @package    booktool_exportimscp
 * @category   phpunit
 * @copyright  2013 Frédéric Massart
 * 
 */

defined('LION_INTERNAL') || die();
global $CFG;

/**
 * Events tests class.
 *
 * @package    booktool_exportimscp
 * @category   phpunit
 * @copyright  2013 Frédéric Massart
 * 
 */
class booktool_exportimscp_events_testcase extends advanced_testcase {

    public function setUp() {
        $this->resetAfterTest();
    }

    public function test_book_exported() {
        // There is no proper API to call to test the event, so what we are
        // doing here is simply making sure that the events returns the right information.

        $course = $this->getDataGenerator()->create_course();
        $book = $this->getDataGenerator()->create_module('book', array('course' => $course->id));
        $context = context_module::instance($book->cmid);

        $event = \booktool_exportimscp\event\book_exported::create_from_book($book, $context);

        // Triggering and capturing the event.
        $sink = $this->redirectEvents();
        $event->trigger();
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = reset($events);

        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\booktool_exportimscp\event\book_exported', $event);
        $this->assertEquals(context_module::instance($book->cmid), $event->get_context());
        $this->assertEquals($book->id, $event->objectid);
        $expected = array($course->id, 'book', 'exportimscp', 'tool/exportimscp/index.php?id=' . $book->cmid,
            $book->id, $book->cmid);
        $this->assertEventLegacyLogData($expected, $event);
        $this->assertEventContextNotUsed($event);
    }

}
