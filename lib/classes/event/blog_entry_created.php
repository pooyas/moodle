<?php

/**
 * Event for when a new blog entry is added..
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Class blog_entry_created
 *
 * Class for event to be triggered when a blog entry is created.
 *
 * @package    core
 * @since      Lion 2.6
 * @copyright  2015 Pooya Saeedi
 * 
 */
class blog_entry_created extends base {

    /** @var \blog_entry A reference to the active blog_entry object. */
    protected $blogentry;

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->context = \context_system::instance();
        $this->data['objecttable'] = 'post';
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Set blog_entry object to be used by observers.
     *
     * @param \blog_entry $blogentry A reference to the active blog_entry object.
     */
    public function set_blog_entry(\blog_entry $blogentry) {
        $this->blogentry = $blogentry;
    }

    /**
     * Returns created blog_entry object for event observers.
     *
     * @throws \coding_exception
     * @return \blog_entry
     */
    public function get_blog_entry() {
        if ($this->is_restored()) {
            throw new \coding_exception('Function get_blog_entry() can not be used on restored events.');
        }
        return $this->blogentry;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('evententryadded', 'core_blog');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' created the blog entry with id '$this->objectid'.";
    }

    /**
     * Returns relevant URL.
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/blog/index.php', array('entryid' => $this->objectid));
    }

    /**
     * Does this event replace legacy event?
     *
     * @return string legacy event name
     */
    public static function get_legacy_eventname() {
        return 'blog_entry_added';
    }

    /**
     * Legacy event data if get_legacy_eventname() is not empty.
     *
     * @return \blog_entry
     */
    protected function get_legacy_eventdata() {
        return $this->blogentry;
    }

    /**
     * Replace add_to_log() statement.
     *
     * @return array of parameters to be passed to legacy add_to_log() function.
     */
    protected function get_legacy_logdata() {
        return array (SITEID, 'blog', 'add', 'index.php?userid=' . $this->relateduserid . '&entryid=' . $this->objectid,
            $this->blogentry->subject);
    }

    /**
     * Custom validations.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }
    }
}
