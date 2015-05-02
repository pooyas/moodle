<?php

/**
 * The mod_wiki page deleted event.
 *
 * @package    mod_wiki
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */

namespace mod_wiki\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_wiki page deleted event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int subwikiid: (optional) id subwiki.
 * }
 *
 * @package    mod_wiki
 * @since      Lion 2.7
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */
class page_deleted extends \core\event\base {
    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'wiki_pages';
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventpagedeleted', 'mod_wiki');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' deleted the page with id '$this->objectid' for the wiki with " .
            "course module id '$this->contextinstanceid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return(array($this->courseid, 'wiki', 'admin', 'admin.php?pageid=' . $this->objectid, $this->objectid,
            $this->contextinstanceid));
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/wiki/admin.php', array('pageid' => $this->objectid));
    }
}
