<?php


/**
 * core_notes data generator.
 *
 * @category   test
 * @package    notes
 * @subpackage tests
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * core_notes data generator class.
 *
 * @category   test
 */
class core_notes_generator extends component_generator_base {

    /**
     * @var number of created instances
     */
    protected $instancecount = 0;

    /**
     * To be called from data reset code only,
     * do not use in tests.
     * @return void
     */
    public function reset() {
        $this->instancecount = 0;
    }

    /**
     * Create a new note.
     *
     * @param array|stdClass $record
     * @throws coding_exception
     * @return stdClass activity record with extra cmid field
     */
    public function create_instance($record = null) {
        global $CFG, $USER;
        require_once("$CFG->dirroot/notes/lib.php");

        $this->instancecount++;
        $i = $this->instancecount;
        $record = (object)(array)$record;

        if (empty($record->courseid)) {
            throw new coding_exception('Module generator requires $record->courseid.');
        }
        if (empty($record->userid)) {
            throw new coding_exception('Module generator requires $record->userid.');
        }
        if (!isset($record->module)) {
            $record->module = 'notes';
        }
        if (!isset($record->groupid)) {
            $record->groupid = 0;
        }
        if (!isset($record->moduleid)) {
            $record->moduleid = 0;
        }
        if (!isset($record->coursemoduleid)) {
            $record->coursemoduleid = 0;
        }
        if (!isset($record->subject)) {
            $record->subject = '';
        }
        if (!isset($record->summary)) {
            $record->summary = null;
        }
        if (!isset($record->content)) {
            $record->content = "This is test generated note - $i .";
        }
        if (!isset($record->uniquehash)) {
            $record->uniquehash = '';
        }
        if (!isset($record->rating)) {
            $record->rating = 0;
        }
        if (!isset($record->format)) {
            $record->format = FORMAT_PLAIN;
        }
        if (!isset($record->summaryformat)) {
            $record->summaryformat = FORMAT_LION;
        }
        if (!isset($record->attachment)) {
            $record->attachment = null;
        }
        if (!isset($record->publishstate)) {
            $record->publishstate = NOTES_STATE_SITE;
        }
        if (!isset($record->lastmodified)) {
            $record->lastmodified = time();
        }
        if (!isset($record->created)) {
            $record->created = time();
        }
        if (!isset($record->usermodified)) {
            $record->usermodified = $USER->id;
        }

        note_save($record);
        return $record;
    }

}

