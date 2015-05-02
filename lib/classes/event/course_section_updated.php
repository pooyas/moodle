<?php

/**
 * Course section updated event.
 *
 * @package    core
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Course section updated event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int sectionnum: section number.
 * }
 *
 * @package    core
 * @since      Lion 2.6
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */
class course_section_updated extends base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['objecttable'] = 'course_sections';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcoursesectionupdated');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated section number '{$this->other['sectionnum']}' for the " .
            "course with id '$this->courseid'";
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/course/editsection.php', array('id' => $this->objectid));
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $sectiondata = $this->get_record_snapshot('course_sections', $this->objectid);
        return array($this->courseid, 'course', 'editsection', 'editsection.php?id=' . $this->objectid, $sectiondata->section);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['sectionnum'])) {
            throw new \coding_exception('The \'sectionnum\' value must be set in other.');
        }
    }
}
