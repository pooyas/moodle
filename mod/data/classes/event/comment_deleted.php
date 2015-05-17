<?php


/**
 * The mod_data comment deleted event.
 *
 * @package    mod
 * @subpackage data
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_data\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_data comment deleted event class.
 *
 */
class comment_deleted extends \core\event\comment_deleted {
    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/data/view.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' deleted the comment with id '$this->objectid' from the database activity with " .
            "course module id '$this->contextinstanceid'.";
    }
}
