<?php

/**
 * Course deleted event.
 *
 * @package    core
 * @copyright  2013 Mark Nelson <markn@lion.com>
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Course deleted event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string fullname: fullname of course.
 *      - string shortname: (optional) shortname of course.
 *      - string idnumber: (optional) id number of course.
 * }
 *
 * @package    core
 * @since      Lion 2.6
 * @copyright  2013 Mark Nelson <markn@lion.com>
 * 
 */
class course_deleted extends base {

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
        return get_string('eventcoursedeleted');
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' deleted the course with id '$this->courseid'.";
    }

    /**
     * Returns the name of the legacy event.
     *
     * @return string legacy event name
     */
    public static function get_legacy_eventname() {
        return 'course_deleted';
    }

    /**
     * Returns the legacy event data.
     *
     * @return \stdClass the course that was deleted
     */
    protected function get_legacy_eventdata() {
        $course = $this->get_record_snapshot('course', $this->objectid);
        $course->context = $this->context;
        $course->timemodified = $this->data['timecreated'];
        return $course;
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array(SITEID, 'course', 'delete', 'view.php?id=' . $this->objectid, $this->other['fullname']  . '(ID ' . $this->objectid . ')');
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['fullname'])) {
            throw new \coding_exception('The \'fullname\' value must be set in other.');
        }
    }
}
