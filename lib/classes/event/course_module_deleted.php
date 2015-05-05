<?php

/**
 * Event to be triggered when a new course module is deleted.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * .
 */

namespace core\event;
defined('LION_INTERNAL') || die();

/**
 * Class course_module_deleted
 *
 * Class for event to be triggered when a course module is deleted.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string modulename: name of module deleted.
 *      - string instanceid: id of module instance.
 * }
 *
 * @package    core
 * @since      Lion 2.6
 * @copyright  2015 Pooya Saeedi
 * .
 */
class course_module_deleted extends base {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['objecttable'] = 'course_modules';
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcoursemoduledeleted', 'core');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' deleted the '{$this->other['modulename']}' activity with " .
            "course module id '$this->contextinstanceid'.";
    }

    /**
     * Legacy event name.
     *
     * @return string legacy event name
     */
    public static function get_legacy_eventname() {
        return 'mod_deleted';
    }

    /**
     * Legacy event data.
     *
     * @return \stdClass
     */
    protected function get_legacy_eventdata() {
        $eventdata = new \stdClass();
        $eventdata->modulename = $this->other['modulename'];
        $eventdata->cmid       = $this->objectid;
        $eventdata->courseid   = $this->courseid;
        $eventdata->userid     = $this->userid;
        return $eventdata;
    }

    /**
     * replace add_to_log() statement.
     *
     * @return array of parameters to be passed to legacy add_to_log() function.
     */
    protected function get_legacy_logdata() {
        return array ($this->courseid, "course", "delete mod", "view.php?id=$this->courseid",
                $this->other['modulename'] . " " . $this->other['instanceid'], $this->objectid);
    }

    /**
     * custom validations
     *
     * Throw \coding_exception notice in case of any problems.
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->other['modulename'])) {
            throw new \coding_exception('The \'modulename\' value must be set in other.');
        }
        if (!isset($this->other['instanceid'])) {
            throw new \coding_exception('The \'instanceid\' value must be set in other.');
        }
    }
}

