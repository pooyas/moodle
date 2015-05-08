<?php

/**
 * The mod_scorm tracks user report viewed event.
 *
 * @package    mod_scorm
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_scorm\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_scorm tracks user report viewed event class.
 *
 * @property-read array $other {
 *      Extra information about event properties.
 *
 *      - int attemptid: Attempt id.
 *      - int instanceid: Instance id of the scorm activity.
 * }
 *
 * @package    mod_scorm
 * @since      Lion 2.7
 * @copyright  2015 Pooya Saeedi
 * 
 */
class user_report_viewed extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the scorm user report for the user with id '$this->relateduserid'.";
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventuserreportviewed', 'mod_scorm');
    }

    /**
     * Get URL related to the action
     *
     * @return \lion_url
     */
    public function get_url() {
        $params = array(
            'id' => $this->contextinstanceid,
            'user' => $this->relateduserid,
            'attempt' => $this->other['attemptid']
        );
        return new \lion_url('/mod/scorm/userreport.php', $params);
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'scorm', 'userreport', 'report/userreport.php?id=' .
                $this->contextinstanceid . '&user=' . $this->relateduserid . '&attempt=' . $this->other['attemptid'],
                $this->other['instanceid'], $this->contextinstanceid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }
        if (empty($this->other['attemptid'])) {
            throw new \coding_exception('The \'attemptid\' value must be set in other.');
        }
        if (empty($this->other['instanceid'])) {
            throw new \coding_exception('The \'instanceid\' value must be set in other.');
        }
    }
}
