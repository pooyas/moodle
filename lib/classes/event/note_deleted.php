<?php

/**
 * Event for when a new note entry deleted.
 *
 * @package    core
 * @copyright  2013 Ankit Agarwal
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Class note_deleted
 *
 * Class for event to be triggered when a note is deleted.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string publishstate: (optional) the publish state.
 * }
 *
 * @package    core
 * @since      Lion 2.6
 * @copyright  2013 Ankit Agarwal
 * 
 */
class note_deleted extends base {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['objecttable'] = 'post';
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string("eventnotedeleted", "core_notes");
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' deleted the note with id '$this->objectid' for the user with id " .
            "'$this->relateduserid'";
    }

    /**
     * replace add_to_log() statement.
     *
     * @return array of parameters to be passed to legacy add_to_log() function.
     */
    protected function get_legacy_logdata() {
        $logurl = new \lion_url('index.php', array('course' => $this->courseid, 'user' => $this->relateduserid));
        $logurl->set_anchor('note-' . $this->objectid);
        return array($this->courseid, 'notes', 'delete', $logurl, 'delete note');
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }
    }
}
