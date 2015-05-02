<?php

/**
 * Course user report viewed event.
 *
 * @package    core
 * @copyright  2014 Adrian Greeve <adrian@lion.com>
 * 
 */

namespace core\event;
defined('LION_INTERNAL') || die();

/**
 * Course user report viewed event class.
 *
 * Class for event to be triggered when a course user report is viewed.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - string mode: Mode is used to show the user different data.
 * }
 *
 * @package    core
 * @since      Lion 2.7
 * @copyright  2014 Adrian Greeve <adrian@lion.com>
 * 
 */
class course_user_report_viewed extends base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the user report for the course with id '$this->courseid' " .
            "for user with id '$this->relateduserid'.";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcourseuserreportviewed', 'core');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url("/course/user.php", array('id' => $this->courseid, 'user' => $this->relateduserid,
                'mode' => $this->other['mode']));
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'course', 'user report', 'user.php?id=' . $this->courseid . '&amp;user='
                . $this->relateduserid . '&amp;mode=' . $this->other['mode'], $this->relateduserid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if ($this->contextlevel != CONTEXT_COURSE) {
            throw new \coding_exception('Context passed must be course context.');
        }

        if (empty($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }

        // Make sure this class is never used without proper object details.
        if (!isset($this->other['mode'])) {
            throw new \coding_exception('The \'mode\' value must be set in other.');
        }
    }
}
