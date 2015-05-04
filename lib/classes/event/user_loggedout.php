<?php

/**
 * User logout event.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */
namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Event when user logout.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string sessionid: (optional) session id.
 * }
 *
 * @package    core
 * @since      Lion 2.6
 * @copyright  2015 Pooya Saeedi
 * 
 */
class user_loggedout extends base {

    /**
     * Initialise required event data properties.
     */
    protected function init() {
        $this->context = \context_system::instance();
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
        return get_string('eventuserloggedout');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->objectid' has logged out.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/user/view.php', array('id' => $this->objectid));
    }

    /**
     * Return name of the legacy event, which is replaced by this event.
     *
     * @return string legacy event name
     */
    public static function get_legacy_eventname() {
        return 'user_logout';
    }

    /**
     * Return user_logout legacy event data.
     *
     * @return \stdClass user data.
     */
    protected function get_legacy_eventdata() {
        return $this->get_record_snapshot('user', $this->objectid);
    }

    /**
     * Returns array of parameters to be passed to legacy add_to_log() function.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array(SITEID, 'user', 'logout', 'view.php?id='.$this->objectid.'&course='.SITEID, $this->objectid, 0,
            $this->objectid);
    }
}
