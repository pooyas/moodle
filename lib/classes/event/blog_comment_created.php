<?php

/**
 * The blog comment created event.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\event;
defined('LION_INTERNAL') || die();

/**
 * The blog comment created event class.
 *
 */
class blog_comment_created extends comment_created {

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
        return "The user with id '$this->userid' added the comment to the blog with id '{$this->other['itemid']}'.";
    }
}
