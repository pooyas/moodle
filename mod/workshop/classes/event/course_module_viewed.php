<?php

/**
 * The mod_workshop course module viewed event.
 *
 * @package    mod_workshop
 * @copyright  2013 Adrian Greeve <adrian@lion.com>
 * 
 */

namespace mod_workshop\event;

defined('LION_INTERNAL') || die();

global $CFG;
require_once("$CFG->dirroot/mod/workshop/locallib.php");

/**
 * The mod_workshop course module viewed event class.
 *
 * @package    mod_workshop
 * @since      Lion 2.6
 * @copyright  2013 Adrian Greeve
 * 
 */
class course_module_viewed extends \core\event\course_module_viewed {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'workshop';
    }

    /**
     * Does this event replace a legacy event?
     *
     * @return string legacy event name
     */
    public static function get_legacy_eventname() {
        return 'workshop_viewed';
    }

    /**
     * Legacy event data if get_legacy_eventname() is not empty.
     *
     * @return mixed
     */
    protected function get_legacy_eventdata() {
        global $USER;

        $workshop = $this->get_record_snapshot('workshop', $this->objectid);
        $course   = $this->get_record_snapshot('course', $this->courseid);
        $cm       = $this->get_record_snapshot('course_modules', $this->contextinstanceid);
        $workshop = new \workshop($workshop, $cm, $course);
        return (object)array('workshop' => $workshop, 'user' => $USER);
    }
}
