<?php

/**
 * The mod_quiz attempt started event.
 *
 * @package    mod_quiz
 * @copyright  2013 Adrian Greeve <adrian@lion.com>
 * 
 */
namespace mod_quiz\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_quiz attempt started event class.
 *
 * @package    mod_quiz
 * @since      Lion 2.6
 * @copyright  2013 Adrian Greeve <adrian@lion.com>
 * 
 */
class attempt_started extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['objecttable'] = 'quiz_attempts';
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->relateduserid' has started the attempt with id '$this->objectid' for the " .
            "quiz with course module id '$this->contextinstanceid'.";
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventquizattemptstarted', 'mod_quiz');
    }

    /**
     * Does this event replace a legacy event?
     *
     * @return string legacy event name
     */
    static public function get_legacy_eventname() {
        return 'quiz_attempt_started';
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/quiz/review.php', array('attempt' => $this->objectid));
    }

    /**
     * Legacy event data if get_legacy_eventname() is not empty.
     *
     * @return \stdClass
     */
    protected function get_legacy_eventdata() {
        $attempt = $this->get_record_snapshot('quiz_attempts', $this->objectid);

        $legacyeventdata = new \stdClass();
        $legacyeventdata->component = 'mod_quiz';
        $legacyeventdata->attemptid = $attempt->id;
        $legacyeventdata->timestart = $attempt->timestart;
        $legacyeventdata->timestamp = $attempt->timestart;
        $legacyeventdata->userid = $this->relateduserid;
        $legacyeventdata->quizid = $attempt->quiz;
        $legacyeventdata->cmid = $this->contextinstanceid;
        $legacyeventdata->courseid = $this->courseid;

        return $legacyeventdata;
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $attempt = $this->get_record_snapshot('quiz_attempts', $this->objectid);

        return array($this->courseid, 'quiz', 'attempt', 'review.php?attempt=' . $this->objectid,
            $attempt->quiz, $this->contextinstanceid);
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
