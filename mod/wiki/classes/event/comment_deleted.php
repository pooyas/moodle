<?php


/**
 * The mod_wiki comment deleted event.
 *
 * @package    mod
 * @subpackage wiki
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_wiki\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_wiki comment deleted event class.
 *
 */
class comment_deleted extends \core\event\comment_deleted {

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
        return "The user with id '$this->userid' deleted a comment with id '$this->objectid' on the page with id " .
            "'{$this->other['itemid']}' for the wiki with course module id '$this->contextinstanceid'.";
    }
}
