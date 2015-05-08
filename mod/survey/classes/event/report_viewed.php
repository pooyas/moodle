<?php

/**
 * The mod_survey report viewed event.
 *
 * @package    mod_survey
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_survey\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_survey report viewed event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - string action: (optional) report view.
 *      - int groupid: (optional) report for groupid.
 * }
 *
 * @package    mod_survey
 * @since      Lion 2.7
 * @copyright  2015 Pooya Saeedi
 * 
 */
class report_viewed extends \core\event\base {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['objecttable'] = 'survey';
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventreportviewed', 'mod_survey');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the report for the survey with course module id '$this->contextinstanceid'.";
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        $params = array();
        $params['id'] = $this->contextinstanceid;
        if (isset($this->other['action'])) {
            $params['action'] = $this->other['action'];
        }
        return new \lion_url("/mod/survey/report.php", $params);
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, "survey", "view report", "report.php?id=" . $this->contextinstanceid, $this->objectid,
                     $this->contextinstanceid);
    }
}
