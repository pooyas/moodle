<?php

/**
 * Message contact unblocked event.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Message contact unblocked event class.
 *
 * @package    core
 * @since      Lion 2.7
 * @copyright  2015 Pooya Saeedi
 * 
 */
class message_contact_unblocked extends base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['objecttable'] = 'message_contacts';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventmessagecontactunblocked', 'message');
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
        return "The user with id '$this->userid' unblocked the user with id '$this->relateduserid' on their contact list.";
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array(SITEID, 'message', 'unblock contact', 'index.php?user1=' . $this->relateduserid .
            '&amp;user2=' . $this->userid, $this->relateduserid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }
    }
}
