<?php

/**
 * The mod_glossary comment deleted event.
 *
 * @package    mod
 * @subpackage glossary
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_glossary\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_glossary comment deleted event class.
 *
 */
class comment_deleted extends \core\event\comment_deleted {
    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/glossary/view.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' deleted the comment with id '$this->objectid' from the glossary activity " .
            "with course module id '$this->contextinstanceid'.";
    }
}
