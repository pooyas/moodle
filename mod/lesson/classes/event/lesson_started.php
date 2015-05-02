<?php

/**
 * The mod_lesson lesson started event.
 *
 * @package    mod_lesson
 * @copyright  2013 Mark Nelson <markn@lion.com>
 * .
 */

namespace mod_lesson\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_lesson lesson started event class.
 *
 * @package    mod_lesson
 * @since      Lion 2.7
 * @copyright  2013 Mark Nelson <markn@lion.com>
 * .
 */
class lesson_started extends \core\event\base {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['objecttable'] = 'lesson';
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventlessonstarted', 'mod_lesson');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/lesson/view.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' started the lesson with course module id '$this->contextinstanceid'.";
    }

    /**
     * Replace add_to_log() statement.
     *
     * @return array of parameters to be passed to legacy add_to_log() function.
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'lesson', 'start', 'view.php?id=' . $this->contextinstanceid,
            $this->objectid, $this->contextinstanceid);
    }
}
