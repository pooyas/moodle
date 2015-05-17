<?php


/**
 * Defines the user list viewed event.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Defines the user list viewed event.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string courseshortname: (optional) the short name of course.
 *      - string coursefullname: (optional) the full name of course.
 * }
 *
 */

class user_list_viewed extends base {

    /**
     * Initialise required event data properties.
     */
    protected function init() {
        $this->data['objecttable'] = 'course';
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventuserlistviewed');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the list of users in the course with id '$this->courseid'.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/user/index.php', array('id' => $this->courseid));
    }

    /**
     * Returns array of parameters to be passed to legacy add_to_log() function.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'user', 'view all', 'index.php?id=' . $this->courseid, '');
    }
}
