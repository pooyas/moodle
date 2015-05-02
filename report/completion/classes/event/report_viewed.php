<?php

/**
 * The report_completion report viewed event.
 *
 * @package    report_completion
 * @copyright  2014 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * 
 */

namespace report_completion\event;

defined('LION_INTERNAL') || die();

/**
 * The report_completion report viewed event class.
 *
 * @package    report_completion
 * @since      Lion 2.7
 * @copyright  2014 onwards Ankit Agarwal <ankit.agrr@gmail.com>
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
        return get_string('eventreportviewed', 'report_completion');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the completion report for the course with id '$this->courseid'.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/report/completion/index.php', array('course' => $this->courseid));
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
    }
}
