<?php

/**
 * The mod_chat message sent event.
 *
 * @package    mod
 * @subpackage chat
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_chat\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_chat message sent event class.
 *
 */
class message_sent extends \core\event\base {

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->relateduserid' has sent a message in the chat with course module id
            '$this->contextinstanceid'.";
    }

    /**
     * Return legacy log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $message = $this->get_record_snapshot('chat_messages', $this->objectid);
        return array($this->courseid, 'chat', 'talk', 'view.php?id=' . $this->contextinstanceid,
            $message->chatid, $this->contextinstanceid, $this->relateduserid);
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventmessagesent', 'mod_chat');
    }

    /**
     * Get URL related to the action
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/chat/view.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'chat_messages';
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
    }
}
