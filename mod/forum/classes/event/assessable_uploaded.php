<?php


/**
 * The mod_forum assessable uploaded event.
 *
 * @package    mod
 * @subpackage forum
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_forum\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_forum assessable uploaded event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int discussionid: id of discussion.
 *      - string triggeredfrom: name of the function from where event was triggered.
 * }
 *
 */
class assessable_uploaded extends \core\event\assessable_uploaded {

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has posted content in the forum post with id '$this->objectid' " .
            "in the discussion '{$this->other['discussionid']}' located in the forum with course module id " .
            "'$this->contextinstanceid'.";
    }

    /**
     * Legacy event data if get_legacy_eventname() is not empty.
     *
     * @return \stdClass
     */
    protected function get_legacy_eventdata() {
        $eventdata = new \stdClass();
        $eventdata->modulename   = 'forum';
        $eventdata->name         = $this->other['triggeredfrom'];
        $eventdata->cmid         = $this->contextinstanceid;
        $eventdata->itemid       = $this->objectid;
        $eventdata->courseid     = $this->courseid;
        $eventdata->userid       = $this->userid;
        $eventdata->content      = $this->other['content'];
        if ($this->other['pathnamehashes']) {
            $eventdata->pathnamehashes = $this->other['pathnamehashes'];
        }
        return $eventdata;
    }

    /**
     * Return the legacy event name.
     *
     * @return string
     */
    public static function get_legacy_eventname() {
        return 'assessable_content_uploaded';
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventassessableuploaded', 'mod_forum');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/forum/discuss.php', array('d' => $this->other['discussionid'], 'parent' => $this->objectid));
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        parent::init();
        $this->data['objecttable'] = 'forum_posts';
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['discussionid'])) {
            throw new \coding_exception('The \'discussionid\' value must be set in other.');
        } else if (!isset($this->other['triggeredfrom'])) {
            throw new \coding_exception('The \'triggeredfrom\' value must be set in other.');
        }
    }
}
