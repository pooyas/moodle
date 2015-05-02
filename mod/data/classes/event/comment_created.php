<?php

/**
 * The mod_data comment created event.
 *
 * @package    mod_data
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */

namespace mod_data\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_data comment created event class.
 *
 * @package    mod_data
 * @since      Lion 2.7
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */
class comment_created extends \core\event\comment_created {
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
        return "The user with id '$this->userid' added the comment with id '$this->objectid' to the database activity with " .
            "course module id '$this->contextinstanceid'.";
    }
}
