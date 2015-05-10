<?php

/**
 * The report_completion user report viewed event.
 *
 * @package    report
 * @subpackage completion
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace report_completion\event;

defined('LION_INTERNAL') || die();

/**
 * The report_completion user report viewed event class.
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
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventuserreportviewed', 'report_completion');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the user completion report for the user with id '$this->relateduserid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $url = 'report/completion/user.php?id=' . $this->relateduserid . '&course=' . $this->courseid;
        return array($this->courseid, 'course', 'report completion', $url, $this->courseid);
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/report/completion/user.php', array('course' => $this->courseid, 'id' => $this->relateduserid));
    }

    /**
     * custom validations.
     *
     * @throws \coding_exception when validation fails.
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if ($this->contextlevel != CONTEXT_COURSE) {
            throw new \coding_exception('Context level must be CONTEXT_COURSE.');
        }

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }
    }
}
