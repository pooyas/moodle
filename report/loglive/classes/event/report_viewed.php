<?php

/**
 * The report_loglive report viewed event.
 *
 * @package    report
 * @subpackage loglive
 * @copyright  2015 Pooya Saeedi
 * 
 */
namespace report_loglive\event;

defined('LION_INTERNAL') || die();

/**
 * The report_loglive report viewed event class.
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
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventreportviewed', 'report_loglive');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the live log report for the course with id '$this->courseid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'course', 'report live', "report/loglive/index.php?id=$this->courseid", $this->courseid);
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/report/loglive/index.php', array('id' => $this->courseid));
    }
}
