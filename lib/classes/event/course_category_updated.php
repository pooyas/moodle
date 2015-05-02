<?php

/**
 * Course category updated event.
 *
 * @package    core
 * @copyright  2014 Mark Nelson <markn@lion.com>
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Course category updated event class.
 *
 * @package    core
 * @since      Lion 2.7
 * @copyright  2014 Mark Nelson <markn@lion.com>
 * 
 */
class course_category_updated extends base {

    /** @var array The legacy log data. */
    private $legacylogdata;

    /**
     * Initialise the event data.
     */
    protected function init() {
        $this->data['objecttable'] = 'course_categories';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcoursecategoryupdated');
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/course/editcategory.php', array('id' => $this->objectid));
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated the course category with id '$this->objectid'.";
    }

    /**
     * Set the legacy data used for add_to_log().
     *
     * @param array $logdata
     */
    public function set_legacy_logdata($logdata) {
        $this->legacylogdata = $logdata;
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        if (!empty($this->legacylogdata)) {
            return $this->legacylogdata;
        }

        return array(SITEID, 'category', 'update', 'editcategory.php?id=' . $this->objectid, $this->objectid);
    }
}
