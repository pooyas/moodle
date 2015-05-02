<?php

/**
 * Events tests.
 *
 * @package    mod_folder
 * @category   test
 * @copyright  2013 Mark Nelson <markn@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

class mod_folder_events_testcase extends advanced_testcase {

    /**
     * Tests set up.
     */
    public function setUp() {
        $this->resetAfterTest();
    }

    /**
     * Test the folder updated event.
     *
     * There is no external API for updating a folder, so the unit test will simply create
     * and trigger the event and ensure the legacy log data is returned as expected.
     */
    public function test_folder_updated() {
        $this->setAdminUser();
        $course = $this->getDataGenerator()->create_course();
        $folder = $this->getDataGenerator()->create_module('folder', array('course' => $course->id));

        $params = array(
            'context' => context_module::instance($folder->cmid),
            'objectid' => $folder->id,
            'courseid' => $course->id
        );
        $event = \mod_folder\event\folder_updated::create($params);
        $event->add_record_snapshot('folder', $folder);

        // Trigger and capturing the event.
        $sink = $this->redirectEvents();
        $event->trigger();
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = reset($events);

        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\mod_folder\event\folder_updated', $event);
        $this->assertEquals(context_module::instance($folder->cmid), $event->get_context());
        $this->assertEquals($folder->id, $event->objectid);
        $expected = array($course->id, 'folder', 'edit', 'edit.php?id=' . $folder->cmid, $folder->id, $folder->cmid);
        $this->assertEventLegacyLogData($expected, $event);
        $this->assertEventContextNotUsed($event);
    }
}
