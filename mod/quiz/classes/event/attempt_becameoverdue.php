<?php


/**
 * The mod_quiz attempt became overdue event.
 *
 * @package    mod
 * @subpackage quiz
 * @copyright  2015 Pooya Saeedi
 */
namespace mod_quiz\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_quiz attempt became overdue event class.
 *
 * Please note that the name of this event is not following the event naming convention.
 * Its name should not be used as a reference for other events to be created.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int submitterid: id of submitter (null when trigged by CLI script).
 *      - int quizid: (optional) the id of the quiz.
 * }
 *
 */
class attempt_becameoverdue extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['objecttable'] = 'quiz_attempts';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The quiz attempt with id '$this->objectid' belonging to the quiz with course module id '$this->contextinstanceid' " .
            "for the user with id '$this->relateduserid' became overdue.";
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventquizattempttimelimitexceeded', 'mod_quiz');
    }

    /**
     * Does this event replace a legacy event?
     *
     * @return string legacy event name
     */
    static public function get_legacy_eventname() {
        return 'quiz_attempt_overdue';
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
        $legacyeventdata->attemptid = $this->objectid;
        $legacyeventdata->timestamp = $attempt->timemodified;
        $legacyeventdata->userid = $this->relateduserid;
        $legacyeventdata->quizid = $attempt->quiz;
        $legacyeventdata->cmid = $this->contextinstanceid;
        $legacyeventdata->courseid = $this->courseid;
        $legacyeventdata->submitterid = $this->other['submitterid'];

        return $legacyeventdata;
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

        if (!array_key_exists('submitterid', $this->other)) {
            throw new \coding_exception('The \'submitterid\' value must be set in other.');
        }
    }
}
