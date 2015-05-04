<?php

/**
 * The blog comment deleted event.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\event;
defined('LION_INTERNAL') || die();

/**
 * The blog comment deleted event class.
 *
 * @package    core
 * @since      Lion 2.7
 * @copyright  2015 Pooya Saeedi
 * 
 */
class blog_comment_deleted extends comment_deleted {

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/blog/index.php', array('entryid' => $this->other['itemid']));
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' deleted the comment for the blog with id '{$this->other['itemid']}'.";
    }
}
