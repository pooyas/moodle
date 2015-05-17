<?php


/**
 * Course module completion event.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Course module completion event class.
 *
 */
class course_module_completion_updated extends base {

    /**
     * Initialise required event data properties.
     */
    protected function init() {
        $this->data['objecttable'] = 'course_modules_completion';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcoursemodulecompletionupdated', 'core_completion');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated the completion state for the course module with id '$this->contextinstanceid' " .
            "for the user with id '$this->relateduserid'.";
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
        return 'activity_completion_changed';
    }

    /**
     * Return course module completion legacy event data.
     *
     * @return \stdClass completion data.
     */
    protected function get_legacy_eventdata() {
        return $this->get_record_snapshot('course_modules_completion', $this->objectid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception in case of a problem.
     */
    protected function validate_data() {
        parent::validate_data();
        // Make sure the context level is set to module.
        if ($this->contextlevel !== CONTEXT_MODULE) {
            throw new \coding_exception('Context level must be CONTEXT_MODULE.');
        }

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }
    }
}
