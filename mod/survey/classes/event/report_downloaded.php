<?php

/**
 * The mod_survey report downloaded event.
 *
 * @package    mod_survey
 * @copyright  2014 Rajesh Taneja <rajesh@lion.com>
 * 
 */

namespace mod_survey\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_survey report downloaded event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - string type: Type of report format downloaded.
 *      - int groupid: (optional) report for groupid.
 * }
 *
 * @package    mod_survey
 * @since      Lion 2.7
 * @copyright  2014 Rajesh Taneja <rajesh@lion.com>
 * 
 */
class report_downloaded extends \core\event\base {

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
        return get_string('eventreportdownloaded', 'mod_survey');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' downloaded the report for the survey with course module id '$this->contextinstanceid'.";
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        $params = array('id' => $this->contextinstanceid, 'type' => $this->other['type']);
        if (isset($this->other['groupid'])) {
            $params['group'] = $this->other['groupid'];
        }
        return new \lion_url("/mod/survey/download.php", $params);
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, "survey", "download", $this->get_url(), $this->objectid, $this->contextinstanceid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (empty($this->other['type'])) {
            throw new \coding_exception('The \'type\' value must be set in other.');
        }
    }
}
