<?php

/**
 * The report_outline activity report viewed event.
 *
 * @package    report_outline
 * @copyright  2015 Pooya Saeedi
 * 
 */
namespace report_outline\event;

defined('LION_INTERNAL') || die();

/**
 * The report_outline activity report viewed event class.
 *
 * @package    report_outline
 * @since      Lion 2.7
 * @copyright  2015 Pooya Saeedi
 * 
 */
class activity_report_viewed extends \core\event\base {

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
        return get_string('eventactivityreportviewed', 'report_outline');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the outline activity report for the course with id '$this->courseid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'course', 'report outline', "report/outline/index.php?id=$this->courseid", $this->courseid);
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/report/outline/index.php', array('course' => $this->courseid));
    }
}
