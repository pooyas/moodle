<?php

/**
 * The mod_forum subscribers list viewed event.
 *
 * @package    mod
 * @subpackage forum
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_forum\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_forum subscribers list viewed event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int forumid: The id of the forum which the subscriberslist has been viewed.
 * }
 *
 */
class subscribers_viewed extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has viewed the subscribers list for the forum with course " .
            "module id '$this->contextinstanceid'.";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventsubscribersviewed', 'mod_forum');
    }

    /**
     * Get URL related to the action
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/forum/subscribers.php', array('id' => $this->other['forumid']));
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'forum', 'view subscribers', 'subscribers.php?id=' . $this->other['forumid'],
            $this->other['forumid'], $this->contextinstanceid);
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

