<?php

/**
 * Event for when blog entries are viewed.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */
namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Class for event to be triggered when blog entries are viewed.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int entryid: (optional) id of the entry.
 *      - int tagid: (optional) id of the tag.
 *      - int userid: (optional) id of the user.
 *      - int modid: (optional) id of the mod.
 *      - int groupid: (optional) id of the group.
 *      - int courseid: (optional) id of associated course.
 *      - string search: (optional) the string used to search.
 *      - int fromstart: (optional) the time to search from.
 * }
 *
 */
class blog_entries_viewed extends base {

    /** @var array List of url params accepted*/
    private $validparams = array('entryid', 'tagid', 'userid', 'modid', 'groupid', 'courseid', 'search', 'fromstart');

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->context = \context_system::instance();
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventblogentriesviewed', 'core_blog');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed blog entries.";
    }

    /**
     * Returns relevant URL.
     * @return \lion_url
     */
    public function get_url() {
        $params = array();
        foreach ($this->validparams as $param) {
            if (!empty($this->other[$param])) {
                $params[$param] = $this->other[$param];
            }
        }
        return new \lion_url('/blog/index.php', $params);
    }

    /**
     * replace add_to_log() statement.
     *
     * @return array of parameters to be passed to legacy add_to_log() function.
     */
    protected function get_legacy_logdata() {
        $params = array();
        foreach ($this->validparams as $param) {
            if (!empty($this->other[$param])) {
                $params[$param] = $this->other[$param];
            }
        }
        $url = new \lion_url('index.php', $params);
        return array (SITEID, 'blog', 'view', $url->out(), 'view blog entry');
    }
}
