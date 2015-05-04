<?php

/**
 * The mod_wiki comment created event.
 *
 * @package    mod_wiki
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_wiki\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_wiki comment created event class.
 *
 * @package    mod_wiki
 * @since      Lion 2.7
 * @copyright  2015 Pooya Saeedi
 * 
 */
class comment_created extends \core\event\comment_created {

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/wiki/comments.php', array('pageid' => $this->other['itemid']));
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' added a comment with id '$this->objectid' on the page with id " .
            "'{$this->other['itemid']}' for the wiki with course module id '$this->contextinstanceid'.";
    }
}
