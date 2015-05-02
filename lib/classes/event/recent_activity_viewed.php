<?php

/**
 * Event for recent activity page.
 *
 * @package    core
 * @copyright  2014 Petr Skoda
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Event for recent activity page.
 *
 * @package    core
 * @since      Lion 2.7
 * @copyright  2014 Petr Skoda
 * 
 */
class recent_activity_viewed extends base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventrecentactivityviewed', 'core');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the recent activity report in the course with id '$this->courseid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, "course", "recent", "recent.php?id=$this->courseid", $this->courseid);
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/course/recent.php', array('id' => $this->courseid));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     */
    protected function validate_data() {
        parent::validate_data();

        if ($this->contextlevel != CONTEXT_COURSE) {
            throw new \coding_exception('Context level must be CONTEXT_COURSE.');
        }
    }
}

