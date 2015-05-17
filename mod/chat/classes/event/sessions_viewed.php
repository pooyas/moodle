<?php


/**
 * The mod_chat sessions viewed event.
 *
 * @package    mod
 * @subpackage chat
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_chat\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_chat sessions viewed event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int start: start of period.
 *      - int end: end of period.
 * }
 *
 */
class sessions_viewed extends \core\event\base {

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has viewed the sessions of the chat with course module id
            '$this->contextinstanceid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'chat', 'report', 'report.php?id=' . $this->contextinstanceid,
            $this->objectid, $this->contextinstanceid);
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventsessionsviewed', 'mod_chat');
    }

    /**
     * Get URL related to the action
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/chat/report.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'chat';
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->other['start'])) {
            throw new \coding_exception('The \'start\' value must be set in other.');
        }
        if (!isset($this->other['end'])) {
            throw new \coding_exception('The \'end\' value must be set in other.');
        }
    }

}
