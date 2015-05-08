<?php

/**
 * Message sent event.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Message sent event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int messageid: the id of the message.
 * }
 *
 */
class message_sent extends base {
    /**
     * Create event using ids.
     * @param int $userfromid
     * @param int $usertoid
     * @param int $messageid
     * @return message_sent
     */
    public static function create_from_ids($userfromid, $usertoid, $messageid) {
        // We may be sending a message from the 'noreply' address, which means we are not actually sending a
        // message from a valid user. In this case, we will set the userid to 0.
        // Check if the userid is valid.
        if (!\core_user::is_real_user($userfromid)) {
            $userfromid = 0;
        }

        $event = self::create(array(
            'userid' => $userfromid,
            'context' => \context_system::instance(),
            'relateduserid' => $usertoid,
            'other' => array(
                // In earlier versions it can either be the id in the 'message_read' or 'message' table.
                // Now it is always the id from 'message' table. Please note that the record is still moved
                // to the 'message_read' table later when message marked as read.
                'messageid' => $messageid
            )
        ));

        return $event;
    }

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventmessagesent', 'message');
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/message/index.php', array('user1' => $this->userid, 'user2' => $this->relateduserid));
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        // Check if we are sending from a valid user.
        if (\core_user::is_real_user($this->userid)) {
            return "The user with id '$this->userid' sent a message to the user with id '$this->relateduserid'.";
        }

        return "A message was sent by the system to the user with id '$this->relateduserid'.";
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        // The add_to_log function was only ever called when we sent a message from one user to another. We do not want
        // to return the legacy log data if we are sending a system message, so check that the userid is valid.
        if (\core_user::is_real_user($this->userid)) {
            return array(SITEID, 'message', 'write', 'index.php?user=' . $this->userid . '&id=' . $this->relateduserid .
                '&history=1#m' . $this->other['messageid'], $this->userid);
        }

        return null;
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

        if (!isset($this->other['messageid'])) {
            throw new \coding_exception('The \'messageid\' value must be set in other.');
        }
    }
}
