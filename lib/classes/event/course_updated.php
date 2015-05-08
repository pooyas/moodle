<?php

/**
 * Course updated event.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Course updated event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string shortname: (optional) shortname of course.
 *      - string fullname: (optional) fullname of course.
 * }
 *
 */
class course_updated extends base {

    /** @var array The legacy log data. */
    private $legacylogdata;

    /**
     * Initialise the event data.
     */
    protected function init() {
        $this->data['objecttable'] = 'course';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcourseupdated');
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated the course with id '$this->courseid'.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/course/edit.php', array('id' => $this->objectid));
    }

    /**
     * Returns the name of the legacy event.
     *
     * @return string legacy event name
     */
    public static function get_legacy_eventname() {
        return 'course_updated';
    }

    /**
     * Returns the legacy event data.
     *
     * @return \stdClass the course that was updated
     */
    protected function get_legacy_eventdata() {
        return $this->get_record_snapshot('course', $this->objectid);
    }

    /**
     * Set the legacy data used for add_to_log().
     *
     * @param array $logdata
     */
    public function set_legacy_logdata($logdata) {
        $this->legacylogdata = $logdata;
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return $this->legacylogdata;
    }
}
