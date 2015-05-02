<?php

/**
 * The mod_quiz user override deleted event.
 *
 * @package    mod_quiz
 * @copyright  2014 Mark Nelson <markn@lion.com>
 * 
 */
namespace mod_quiz\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_quiz user override deleted event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int quizid: the id of the quiz.
 * }
 *
 * @package    mod_quiz
 * @since      Lion 2.7
 * @copyright  2014 Mark Nelson <markn@lion.com>
 * 
 */
class user_override_deleted extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['objecttable'] = 'quiz_overrides';
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventoverridedeleted', 'mod_quiz');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' deleted the override with id '$this->objectid' for the quiz with " .
            "course module id '$this->contextinstanceid' for the user with id '{$this->relateduserid}'.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/quiz/overrides.php', array('cmid' => $this->contextinstanceid));
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'quiz', 'delete override', 'overrides.php?cmid=' . $this->contextinstanceid,
            $this->other['quizid'], $this->contextinstanceid);
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

        if (!isset($this->other['quizid'])) {
            throw new \coding_exception('The \'quizid\' value must be set in other.');
        }
    }
}
