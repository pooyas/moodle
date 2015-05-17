<?php


/**
 * Message contact added event.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Message contact added event class.
 *
 */
class message_contact_added extends base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['objecttable'] = 'message_contacts';
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventmessagecontactadded', 'message');
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
        return "The user with id '$this->userid' added the user with id '$this->relateduserid' to their contact list.";
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array(SITEID, 'message', 'add contact', 'index.php?user1=' . $this->relateduserid .
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
