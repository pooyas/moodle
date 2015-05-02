<?php

/**
 * The mod_wiki comments viewed event.
 *
 * @package    mod_wiki
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */

namespace mod_wiki\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_wiki comments viewed event class.
 *
 * @package    mod_wiki
 * @since      Lion 2.7
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */
class comments_viewed extends \core\event\comments_viewed {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        parent::init();
        $this->data['objecttable'] = 'wiki_pages';
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the comments for the page with id '$this->objectid' for the wiki " .
            "with course module id '$this->contextinstanceid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return(array($this->courseid, 'wiki', 'comments',
            'comments.php?pageid=' . $this->objectid, $this->objectid, $this->contextinstanceid));
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/wiki/comments.php', array('pageid' => $this->objectid));
    }
}
