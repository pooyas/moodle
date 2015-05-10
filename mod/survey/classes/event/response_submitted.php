<?php

/**
 * The mod_survey response submitted event.
 *
 * @package    mod
 * @subpackage survey
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_survey\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_survey response submitted event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int surveyid: ID of survey for which response was submitted.
 * }
 *
 */
class response_submitted extends \core\event\base {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventresponsesubmitted', 'mod_survey');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' submitted a response for the survey with course module id '$this->contextinstanceid'.";
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url("/mod/survey/view.php", array('id' => $this->contextinstanceid));
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, "survey", "submit", "view.php?id=" . $this->contextinstanceid, $this->other['surveyid'],
                     $this->contextinstanceid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (empty($this->other['surveyid'])) {
            throw new \coding_exception('The \'surveyid\' value must be set in other.');
        }
    }
}
