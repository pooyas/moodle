<?php

/**
 * The mod_quiz question manually graded event.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */
namespace mod_quiz\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_quiz question manually graded event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int quizid: the id of the quiz.
 *      - int attemptid: the id of the attempt.
 *      - int slot: the question number in the attempt.
 * }
 *
 */
class question_manually_graded extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['objecttable'] = 'question';
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventquestionmanuallygraded', 'mod_quiz');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' manually graded the question with id '$this->objectid' for the attempt " .
            "with id '{$this->other['attemptid']}' for the quiz with course module id '$this->contextinstanceid'.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/quiz/comment.php', array('attempt' => $this->other['attemptid'],
            'slot' => $this->other['slot']));
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'quiz', 'manualgrade', 'comment.php?attempt=' . $this->other['attemptid'] .
            '&slot=' . $this->other['slot'], $this->other['quizid'], $this->contextinstanceid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['quizid'])) {
            throw new \coding_exception('The \'quizid\' value must be set in other.');
        }

        if (!isset($this->other['attemptid'])) {
            throw new \coding_exception('The \'attemptid\' value must be set in other.');
        }

        if (!isset($this->other['slot'])) {
            throw new \coding_exception('The \'slot\' value must be set in other.');
        }

    }
}
