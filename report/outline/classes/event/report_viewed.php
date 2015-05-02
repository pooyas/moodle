<?php

/**
 * The report_outline outline report viewed event.
 *
 * @package    report_outline
 * @copyright  2013 Ankit Agarwal
 * 
 */
namespace report_outline\event;

defined('LION_INTERNAL') || die();

/**
 * The report_outline outline report viewed event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - string mode: display mode.
 * }
 *
 * @package    report_outline
 * @since      Lion 2.7
 * @copyright  2013 Ankit Agarwal
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
        return get_string('eventoutlinereportviewed', 'report_outline');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the outline report for the user with id '$this->relateduserid' " .
            "for the course with id '$this->courseid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $url = "report/outline/user.php?id=". $this->userid . "&course=" . $this->courseid . "&mode=" . $this->other['mode'];
        return array($this->courseid, 'course', 'report outline', $url, $this->courseid);
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/report/outline/user.php', array('course' => $this->courseid, 'id' => $this->relateduserid,
                'mode' => $this->other['mode']));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (empty($this->other['mode'])) {
            throw new \coding_exception('The \'mode\' value must be set in other.');
        }
        if (empty($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }
    }
}
