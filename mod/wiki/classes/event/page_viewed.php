<?php


/**
 * The mod_wiki page viewed event.
 *
 * @package    mod
 * @subpackage wiki
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_wiki\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_wiki page viewed event class.
 *
 */
class page_viewed extends \core\event\base {
    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'wiki_pages';
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventpageviewed', 'mod_wiki');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the page with id '$this->objectid' for the wiki with " .
            "course module id '$this->contextinstanceid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        if (!empty($this->other['wid'])) {
            return(array($this->courseid, 'wiki', 'view',
                'view.php?wid=' . $this->data['other']['wid'] . '&title=' . $this->data['other']['title'],
                $this->data['other']['wid'], $this->contextinstanceid));
        } else if (!empty($this->other['prettyview'])) {
            return(array($this->courseid, 'wiki', 'view',
                'prettyview.php?pageid=' . $this->objectid, $this->objectid, $this->contextinstanceid));
        } else {
            return(array($this->courseid, 'wiki', 'view',
                'view.php?pageid=' . $this->objectid, $this->objectid, $this->contextinstanceid));
        }
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        if (!empty($this->data['other']['wid'])) {
            return new \lion_url('/mod/wiki/view.php', array('wid' => $this->data['other']['wid'],
                    'title' => $this->data['other']['title'],
                    'uid' => $this->relateduserid,
                    'groupanduser' => $this->data['other']['groupanduser'],
                    'group' => $this->data['other']['group']
                ));
        } else if (!empty($this->other['prettyview'])) {
            return new \lion_url('/mod/wiki/prettyview.php', array('pageid' => $this->objectid));
        } else {
            return new \lion_url('/mod/wiki/view.php', array('pageid' => $this->objectid));
        }
    }
}
