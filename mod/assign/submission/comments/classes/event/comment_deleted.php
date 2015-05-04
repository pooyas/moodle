<?php

/**
 * The assignsubmission_comments comment deleted event.
 *
 * @package    assignsubmission_comments
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace assignsubmission_comments\event;
defined('LION_INTERNAL') || die();

/**
 * The assignsubmission_comments comment deleted event.
 *
 * @package    assignsubmission_comments
 * @since      Lion 2.7
 * @copyright  2015 Pooya Saeedi
 * 
 */
class comment_deleted extends \core\event\comment_deleted {
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
        return "The user with id '$this->userid' deleted the comment with id '$this->objectid' from the submission " .
            "with id '{$this->other['itemid']}' for the assignment with course module id '$this->contextinstanceid'.";
    }
}
