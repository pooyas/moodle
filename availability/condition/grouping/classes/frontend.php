<?php

/**
 * Front-end class.
 *
 * @package availability_grouping
 * @copyright 2014 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace availability_grouping;

defined('LION_INTERNAL') || die();

/**
 * Front-end class.
 *
 * @package availability_grouping
 * @copyright 2014 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class frontend extends \core_availability\frontend {
    /** @var array Array of grouping info for course */
    protected $allgroupings;
    /** @var int Course id that $allgroupings is for */
    protected $allgroupingscourseid;

    protected function get_javascript_init_params($course, \cm_info $cm = null,
            \section_info $section = null) {
        // Get all groups for course.
        $groupings = $this->get_all_groupings($course->id);

        // Change to JS array format and return.
        $jsarray = array();
        $context = \context_course::instance($course->id);
        foreach ($groupings as $rec) {
            $jsarray[] = (object)array('id' => $rec->id, 'name' =>
                    format_string($rec->name, true, array('context' => $context)));
        }
        return array($jsarray);
    }

    /**
     * Gets all the groupings on the course.
     *
     * @param int $courseid Course id
     * @return array Array of grouping objects
     */
    protected function get_all_groupings($courseid) {
        global $DB;
        if ($courseid != $this->allgroupingscourseid) {
            $this->allgroupings = $DB->get_records('groupings',
                    array('courseid' => $courseid), 'id, name');
            $this->allgroupingscourseid = $courseid;
        }
        return $this->allgroupings;
    }

    protected function allow_add($course, \cm_info $cm = null,
            \section_info $section = null) {
        global $CFG, $DB;

        // Check if groupings are in use for the course. (Unlike the 'group'
        // condition there is no case where you might want to set up the
        // condition before you set a grouping - there is no 'any grouping'
        // option.)
        return count($this->get_all_groupings($course->id)) > 0;
    }
}
