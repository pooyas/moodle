<?php

/**
 * User deleted event.
 *
 * @package    core
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */
namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * User deleted event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string username: name of user.
 *      - string email: user email.
 *      - string idnumber: user idnumber.
 *      - string picture: user picture.
 *      - int mnethostid: mnet host id.
 * }
 *
 * @package    core
 * @since      Lion 2.6
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */
class user_deleted extends base {

    /**
     * Initialise required event data properties.
     */
    protected function init() {
        $this->data['objecttable'] = 'user';
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventuserdeleted');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' deleted the user with id '$this->objectid'.";
    }

    /**
     * Return name of the legacy event, which is replaced by this event.
     *
     * @return string legacy event name
     */
    public static function get_legacy_eventname() {
        return 'user_deleted';
    }

    /**
     * Return user_deleted legacy event data.
     *
     * @return \stdClass user data.
     */
    protected function get_legacy_eventdata() {
        $user = $this->get_record_snapshot('user', $this->objectid);
        $user->deleted = 0;
        $user->username = $this->other['username'];
        $user->email = $this->other['email'];
        $user->idnumber = $this->other['idnumber'];
        $user->picture = $this->other['picture'];

        return $user;
    }

    /**
     * Returns array of parameters to be passed to legacy add_to_log() function.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $user = $this->get_record_snapshot('user', $this->objectid);
        return array(SITEID, 'user', 'delete', 'view.php?id=' . $user->id, $user->firstname . ' ' . $user->lastname);
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
            debugging('The \'relateduserid\' value must be specified in the event.', DEBUG_DEVELOPER);
            $this->relateduserid = $this->objectid;
        }

        if (!isset($this->other['username'])) {
            throw new \coding_exception('The \'username\' value must be set in other.');
        }

        if (!isset($this->other['email'])) {
            throw new \coding_exception('The \'email\' value must be set in other.');
        }

        if (!isset($this->other['idnumber'])) {
            throw new \coding_exception('The \'idnumber\' value must be set in other.');
        }

        if (!isset($this->other['picture'])) {
            throw new \coding_exception('The \'picture\' value must be set in other.');
        }

        if (!isset($this->other['mnethostid'])) {
            throw new \coding_exception('The \'mnethostid\' value must be set in other.');
        }
    }
}
