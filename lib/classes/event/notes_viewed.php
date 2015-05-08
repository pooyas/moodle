<?php

/**
 * Event for when a new note entry viewed.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Class note_viewed
 *
 * Class for event to be triggered when a note is viewed.
 *
 */
class notes_viewed extends base {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string("eventnotesviewed", "core_notes");
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        if (!empty($this->relateduserid)) {
            return "The user with id '$this->userid' viewed the notes for the user with id '$this->relateduserid'.";
        }

        return "The user with id '$this->userid' viewed the notes for the course with id '$this->courseid'.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/notes/index.php', array('course' => $this->courseid, 'user' => $this->relateduserid));
    }

    /**
     * replace add_to_log() statement.
     *
     * @return array of parameters to be passed to legacy add_to_log() function.
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'notes', 'view', 'index.php?course=' . $this->courseid.'&amp;user=' . $this->relateduserid,
            'view notes');
    }
}
