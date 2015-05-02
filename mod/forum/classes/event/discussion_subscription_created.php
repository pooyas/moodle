<?php

/**
 * The mod_forum discussion_subscription created event.
 *
 * @package    mod_forum
 * @copyright  2014 Andrew Nicols <andrew@nicols.co.uk>
 * 
 */

namespace mod_forum\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_forum discussion_subscription created event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int forumid: The id of the forum which the discussion is in.
 *      - int discussion: The id of the discussion which has been subscribed to.
 * }
 *
 * @package    mod_forum
 * @since      Lion 2.8
 * @copyright  2014 Andrew Nicols <andrew@nicols.co.uk>
 * 
 */
class discussion_subscription_created extends \core\event\base {
    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'forum_discussion_subs';
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' subscribed the user with id '$this->relateduserid' to the discussion " .
            " with id '{$this->other['discussion']}' in the forum with the course module id '$this->contextinstanceid'.";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventdiscussionsubscriptioncreated', 'mod_forum');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/forum/subscribe.php', array(
            'id' => $this->other['forumid'],
            'd' => $this->other['discussion'],
        ));
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

        if (!isset($this->other['forumid'])) {
            throw new \coding_exception('The \'forumid\' value must be set in other.');
        }

        if (!isset($this->other['discussion'])) {
            throw new \coding_exception('The \'discussion\' value must be set in other.');
        }

        if ($this->contextlevel != CONTEXT_MODULE) {
            throw new \coding_exception('Context level must be CONTEXT_MODULE.');
        }
    }
}
