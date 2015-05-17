<?php


/**
 * The mod_quiz report viewed event.
 *
 * @package    mod
 * @subpackage quiz
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_quiz\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_quiz report viewed event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int quizid: the id of the quiz.
 *      - string reportname: the name of the report.
 * }
 *
 */
class report_viewed extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventreportviewed', 'mod_quiz');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the report '" . s($this->other['reportname']) . "' for the quiz with " .
            "course module id '$this->contextinstanceid'.";
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/quiz/report.php', array('id' => $this->contextinstanceid,
            'mode' => $this->other['reportname']));
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'quiz', 'report', 'report.php?id=' . $this->contextinstanceid . '&mode=' .
            $this->other['reportname'], $this->other['quizid'], $this->contextinstanceid);
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

        if (!isset($this->other['reportname'])) {
            throw new \coding_exception('The \'reportname\' value must be set in other.');
        }
    }
}
