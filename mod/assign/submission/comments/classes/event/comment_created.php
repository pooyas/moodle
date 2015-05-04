<?php

/**
 * The assignsubmission_comments comment created event.
 *
 * @package    assignsubmission_comments
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace assignsubmission_comments\event;
defined('LION_INTERNAL') || die();

/**
 * The assignsubmission_comments comment created event class.
 *
 * @package    assignsubmission_comments
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
        return new \lion_url('/mod/assign/view.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' added the comment with id '$this->objectid' to the submission " .
            "with id '{$this->other['itemid']}' for the assignment with course module id '$this->contextinstanceid'.";
    }
}
