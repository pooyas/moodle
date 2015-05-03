<?php

/**
 * Front-end class.
 *
 * @package    availability
 * @subpackage group
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace availability_group;

defined('LION_INTERNAL') || die();

/**
 * Front-end class.
 *
 */
class frontend extends \core_availability\frontend {
    /** @var array Array of group info for course */
    protected $allgroups;
    /** @var int Course id that $allgroups is for */
    protected $allgroupscourseid;

    protected function get_javascript_strings() {
        return array('anygroup');
    }

    protected function get_javascript_init_params($course, \cm_info $cm = null,
            \section_info $section = null) {
        // Get all groups for course.
        $groups = $this->get_all_groups($course->id);

        // Change to JS array format and return.
        $jsarray = array();
        $context = \context_course::instance($course->id);
        foreach ($groups as $rec) {
            $jsarray[] = (object)array('id' => $rec->id, 'name' =>
                    format_string($rec->name, true, array('context' => $context)));
        }
        return array($jsarray);
    }

    /**
     * Gets all groups for the given course.
     *
     * @param int $courseid Course id
     * @return array Array of all the group objects
     */
    protected function get_all_groups($courseid) {
        global $CFG;
        require_once($CFG->libdir . '/grouplib.php');

        if ($courseid != $this->allgroupscourseid) {
            $this->allgroups = groups_get_all_groups($courseid, 0, 0, 'g.id, g.name');
            $this->allgroupscourseid = $courseid;
        }
        return $this->allgroups;
    }

    protected function allow_add($course, \cm_info $cm = null,
            \section_info $section = null) {
        global $CFG;

        // Only show this option if there are some groups.
        return count($this->get_all_groups($course->id)) > 0;
    }
}
