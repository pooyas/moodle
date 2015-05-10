<?php

/**
 * The report_stats user report viewed event.
 *
 * @package    report
 * @subpackage stats
 * @copyright  2015 Pooya Saeedi
 * 
 */
namespace report_stats\event;

defined('LION_INTERNAL') || die();

/**
 * The report_stats user report viewed event class.
 *
 */
class user_report_viewed extends \core\event\base {

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
        return get_string('eventuserreportviewed', 'report_stats');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the user statistics report for the user with id '$this->relateduserid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $url = 'report/stats/user.php?id=' . $this->relateduserid . '&course=' . $this->courseid;
        return (array($this->courseid, 'course', 'report stats', $url, $this->courseid));
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/report/stats/user.php', array('id' => $this->relateduserid, 'course' => $this->courseid));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (empty($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }
    }
}

