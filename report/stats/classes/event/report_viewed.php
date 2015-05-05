<?php

/**
 * The report_stats report viewed event.
 *
 * @package    report_stats
 * @copyright  2015 Pooya Saeedi
 * 
 */
namespace report_stats\event;

defined('LION_INTERNAL') || die();

/**
 * The report_stats report viewed event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int report: (optional) Report type.
 *      - int time: (optional) Time from which report is viewed.
 *      - int mode: (optional) Report mode.
 * }
 *
 * @package    report_stats
 * @since      Lion 2.7
 * @copyright  2015 Pooya Saeedi
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
        return get_string('eventreportviewed', 'report_stats');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the statistics report for the course with id '$this->courseid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, "course", "report stats", "report/stats/index.php?course=$this->courseid", $this->courseid);
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/report/stats/index.php', array('id' => $this->courseid, 'mode' => $this->other['mode'],
                'report' => $this->other['report']));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->other['report'])) {
            throw new \coding_exception('The \'report\' value must be set in other.');
        }

        if (!isset($this->other['time'])) {
            throw new \coding_exception('The \'time\' value must be set in other.');
        }

        if (!isset($this->other['mode'])) {
            throw new \coding_exception('The \'mode\' value must be set in other.');
        }

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }
    }
}

