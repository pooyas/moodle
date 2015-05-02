<?php

/**
 * Generator tests.
 *
 * @package    core_notes
 * @copyright  2013 Ankit Agarwal
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Generator tests class.
 *
 * @package    core_notes
 * @copyright  2013 Ankit Agarwal
 * 
 */
class core_notes_generator_testcase extends advanced_testcase {

    /** Test create_instance method */
    public function test_create_instance() {
        global $DB;
        $this->resetAfterTest();
        $this->setAdminUser();

        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_user();
        $gen = $this->getDataGenerator()->get_plugin_generator('core_notes');

        $this->assertFalse($DB->record_exists('post', array('courseid' => $course->id)));
        $note = $gen->create_instance(array('courseid' => $course->id, 'userid' => $user->id));
        $this->assertEquals(1, $DB->count_records('post', array('courseid' => $course->id, 'userid' => $user->id)));
        $this->assertTrue($DB->record_exists('post', array('id' => $note->id)));

        $params = array('courseid' => $course->id, 'userid' => $user->id, 'publishstate' => NOTES_STATE_DRAFT);
        $note = $gen->create_instance($params);
        $this->assertEquals(2, $DB->count_records('post', array('courseid' => $course->id, 'userid' => $user->id)));
        $this->assertEquals(NOTES_STATE_DRAFT, $DB->get_field_select('post', 'publishstate', 'id = :id',
                array('id' => $note->id)));
    }

    /** Test Exceptions thrown by create_instance method */
    public function test_create_instance_exceptions() {
        $this->resetAfterTest();

        $gen = $this->getDataGenerator()->get_plugin_generator('core_notes');

        // Test not setting userid.
        try {
            $gen->create_instance(array('courseid' => 2));
            $this->fail('A note should not be allowed to be created without associcated userid');
        } catch (coding_exception $e) {
            $this->assertContains('Module generator requires $record->userid', $e->getMessage());
        }

        // Test not setting courseid.
        try {
            $gen->create_instance(array('userid' => 2));
            $this->fail('A note should not be allowed to be created without associcated courseid');
        } catch (coding_exception $e) {
            $this->assertContains('Module generator requires $record->courseid', $e->getMessage());
        }
    }

}

