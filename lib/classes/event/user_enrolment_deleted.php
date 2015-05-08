<?php

/**
 * User enrolment deleted event.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */
namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Event class for when user is unenrolled from a course.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string enrol: name of enrolment instance.
 *      - array userenrolment: user_enrolment record.
 * }
 *
 */
class user_enrolment_deleted extends base {

    /**
     * Initialise required event data properties.
     */
    protected function init() {
        $this->data['objecttable'] = 'user_enrolments';
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventuserenrolmentdeleted', 'core_enrol');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' unenrolled the user with id '$this->relateduserid' using the enrolment method " .
            "'{$this->other['enrol']}' from the course with id '$this->courseid'.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/enrol/users.php', array('id' => $this->courseid));
    }

    /**
     * Return name of the legacy event, which is replaced by this event.
     *
     * @return string legacy event name
     */
    public static function get_legacy_eventname() {
        return 'user_unenrolled';
    }

    /**
     * Return user_unenrolled legacy event data.
     *
     * @return \stdClass
     */
    protected function get_legacy_eventdata() {
        return (object)$this->other['userenrolment'];
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'course', 'unenrol', '../enrol/users.php?id=' . $this->courseid, $this->courseid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->other['userenrolment'])) {
            throw new \coding_exception('The \'userenrolment\' value must be set in other.');
        }
        if (!isset($this->other['enrol'])) {
            throw new \coding_exception('The \'enrol\' value must be set in other.');
        }
        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }
    }
}
