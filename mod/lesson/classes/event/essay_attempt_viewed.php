<?php

/**
 * The mod_lesson essay attempt viewed event.
 *
 * @package    mod_lesson
 * @copyright  2015 Pooya Saeedi
 * .
 */

namespace mod_lesson\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_lesson essay attempt viewed event class.
 *
 * @package    mod_lesson
 * @since      Lion 2.7
 * @copyright  2015 Pooya Saeedi
 * .
 */
class essay_attempt_viewed extends \core\event\base {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['objecttable'] = 'lesson_attempts';
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventessayattemptviewed', 'mod_lesson');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/lesson/essay.php', array('id' => $this->contextinstanceid,
            'mode' => 'grade', 'attemptid' =>  $this->objectid));
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the essay grade for the user with id '$this->relateduserid' for " .
            "the attempt with id '$this->objectid' for the lesson activity with course module id '$this->contextinstanceid'.";
    }

    /**
     * Replace add_to_log() statement.
     *
     * @return array of parameters to be passed to legacy add_to_log() function.
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'lesson', 'view grade', 'essay.php?id=' . $this->contextinstanceid . '&mode=grade&attemptid='
            . $this->objectid, get_string('manualgrading', 'lesson'), $this->contextinstanceid);
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
