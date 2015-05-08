<?php

/**
 * Course content deleted event.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Course content deleted event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - array options: list of options which were skipped while deleting course content.
 * }
 *
 */
class course_content_deleted extends base {

    /**
     * Initialise the event data.
     */
    protected function init() {
        $this->data['objecttable'] = 'course';
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcoursecontentdeleted');
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' deleted content from course with id '$this->courseid'.";
    }

    /**
     * Returns the name of the legacy event.
     *
     * @return string legacy event name
     */
    public static function get_legacy_eventname() {
        return 'course_content_removed';
    }

    /**
     * Returns the legacy event data.
     *
     * @return \stdClass the course the content was deleted from
     */
    protected function get_legacy_eventdata() {
        $course = $this->get_record_snapshot('course', $this->objectid);
        $course->context = $this->context;
        $course->options = $this->other['options'];

        return $course;
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['options'])) {
            throw new \coding_exception('The \'options\' value must be set in other.');
        }
    }
}
