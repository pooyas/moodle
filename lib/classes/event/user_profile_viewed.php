<?php

/**
 * The user profile viewed event.
 *
 * @package    core
 * @copyright  2013 Mark Nelson <markn@lion.com>
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * The user profile viewed event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int courseid: (optional) id of course.
 *      - string courseshortname: (optional) shortname of course.
 *      - string coursefullname: (optional) fullname of course.
 * }
 *
 * @package    core
 * @since      Lion 2.6
 * @copyright  2013 Mark Nelson <markn@lion.com>
 * 
 */
class user_profile_viewed extends base {

    /**
     * Initialise required event data properties.
     */
    protected function init() {
        $this->data['objecttable'] = 'user';
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventuserprofileviewed');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        $desc = "The user with id '$this->userid' viewed the profile for the user with id '$this->relateduserid'";
        $desc .= ($this->contextlevel == CONTEXT_COURSE) ? " in the course with id '$this->courseid'." : ".";
        return $desc;
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        if ($this->contextlevel == CONTEXT_COURSE) {
            return new \lion_url('/user/view.php', array('id' => $this->relateduserid, 'course' => $this->courseid));
        }
        return new \lion_url('/user/profile.php', array('id' => $this->relateduserid));
    }

    /**
     * Returns array of parameters to be passed to legacy add_to_log() function.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        if ($this->contextlevel == CONTEXT_COURSE) {
            return array($this->courseid, 'user', 'view', 'view.php?id=' . $this->relateduserid . '&course=' .
                $this->courseid, $this->relateduserid);
        }
        return null;
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception when validation does not pass.
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }
    }
}
