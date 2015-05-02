<?php

/**
 * Course completed event.
 *
 * @package    core
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Course completed event class.
 *
 * @property-read int $relateduserid user who completed the course
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int relateduserid: deprecated since 2.7, please use property relateduserid
 * }
 *
 * @package    core
 * @since      Lion 2.6
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */
class course_completed extends base {
    /**
     * Create event from course_completion record.
     * @param \stdClass $completion
     * @return course_completed
     */
    public static function create_from_completion(\stdClass $completion) {
        $event = self::create(
            array(
                'objectid' => $completion->id,
                'relateduserid' => $completion->userid,
                'context' => \context_course::instance($completion->course),
                'courseid' => $completion->course,
                'other' => array('relateduserid' => $completion->userid), // Deprecated since 2.7, please use property relateduserid.
            )
        );
        $event->add_record_snapshot('course_completions', $completion);
        return $event;
    }

    /**
     * Initialise required event data properties.
     */
    protected function init() {
        $this->data['objecttable'] = 'course_completions';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcoursecompleted', 'core_completion');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->relateduserid' completed the course with id '$this->courseid'.";
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
     * Return name of the legacy event, which is replaced by this event.
     *
     * @return string legacy event name
     */
    public static function get_legacy_eventname() {
        return 'course_completed';
    }

    /**
     * Return course_completed legacy event data.
     *
     * @return \stdClass completion data.
     */
    protected function get_legacy_eventdata() {
        return $this->get_record_snapshot('course_completions', $this->objectid);
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

        // Check that the 'relateduserid' value is set in other as well. This is because we introduced this in 2.6
        // and some observers may be relying on this value to be present.
        if (!isset($this->other['relateduserid'])) {
            throw new \coding_exception('The \'relateduserid\' value must be set in other.');
        }
    }
}
