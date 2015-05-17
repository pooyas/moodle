<?php

/**
 * Event for when a new blog entry is associated with a context.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */
namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Class for event to be triggered when a new blog entry is associated with a context.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string associatetype: type of blog association, course/coursemodule.
 *      - int blogid: id of blog.
 *      - int associateid: id of associate.
 *      - string subject: blog subject.
 * }
 *
 */
class blog_association_created extends base {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->context = \context_system::instance();
        $this->data['objecttable'] = 'blog_association';
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventblogassociationadded', 'core_blog');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' associated the context '{$this->other['associatetype']}' with id " .
            "'{$this->other['associateid']}' to the blog entry with id '{$this->other['blogid']}'.";
    }

    /**
     * Returns relevant URL.
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/blog/index.php', array('entryid' => $this->other['blogid']));
    }

    /**
     * replace add_to_log() statement.
     *
     * @return array of parameters to be passed to legacy add_to_log() function.
     */
    protected function get_legacy_logdata() {
        if ($this->other['associatetype'] === 'course') {
            return array (SITEID, 'blog', 'add association', 'index.php?userid=' . $this->relateduserid. '&entryid=' .
                    $this->other['blogid'], $this->other['subject'], 0, $this->relateduserid);
        }

        return array (SITEID, 'blog', 'add association', 'index.php?userid=' . $this->relateduserid. '&entryid=' .
                $this->other['blogid'], $this->other['subject'], $this->other['associateid'], $this->relateduserid);
    }

    /**
     * Custom validations.
     *
     * @throws \coding_exception when validation fails.
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }

        if (empty($this->other['associatetype']) || ($this->other['associatetype'] !== 'course'
                && $this->other['associatetype'] !== 'coursemodule')) {
            throw new \coding_exception('The \'associatetype\' value must be set in other and be a valid type.');
        }

        if (!isset($this->other['blogid'])) {
            throw new \coding_exception('The \'blogid\' value must be set in other.');
        }

        if (!isset($this->other['associateid'])) {
            throw new \coding_exception('The \'associateid\' value must be set in other.');
        }

        if (!isset($this->other['subject'])) {
            throw new \coding_exception('The \'subject\' value must be set in other.');
        }
    }
}
