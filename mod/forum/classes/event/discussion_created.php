<?php

/**
 * The mod_forum discussion created event.
 *
 * @package    mod_forum
 * @copyright  2014 Dan Poltawski <dan@lion.com>
 * 
 */

namespace mod_forum\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_forum discussion created event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int forumid: The id of the forum the discussion is in.
 * }
 *
 * @package    mod_forum
 * @since      Lion 2.7
 * @copyright  2014 Dan Poltawski <dan@lion.com>
 * 
 */
class discussion_created extends \core\event\base {
    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'forum_discussions';
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has created the discussion with id '$this->objectid' in the forum " .
            "with course module id '$this->contextinstanceid'.";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventdiscussioncreated', 'mod_forum');
    }

    /**
     * Get URL related to the action
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/forum/discuss.php', array('d' => $this->objectid));
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {

        // The legacy log table expects a relative path to /mod/forum/.
        $logurl = substr($this->get_url()->out_as_local_url(), strlen('/mod/forum/'));

        return array($this->courseid, 'forum', 'add discussion', $logurl, $this->objectid, $this->contextinstanceid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->other['forumid'])) {
            throw new \coding_exception('The \'forumid\' value must be set in other.');
        }

        if ($this->contextlevel != CONTEXT_MODULE) {
            throw new \coding_exception('Context level must be CONTEXT_MODULE.');
        }
    }
}
