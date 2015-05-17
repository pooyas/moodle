<?php


/**
 * Front-end class.
 *
 * @package    availability_condition
 * @subpackage grade
 * @copyright  2015 Pooya Saeedi
 */

namespace availability_grade;

defined('LION_INTERNAL') || die();

/**
 * Front-end class.
 *
 */
class frontend extends \core_availability\frontend {
    protected function get_javascript_strings() {
        return array('option_min', 'option_max', 'label_min', 'label_max');
    }

    protected function get_javascript_init_params($course, \cm_info $cm = null,
            \section_info $section = null) {
        global $DB, $CFG;
        require_once($CFG->libdir . '/gradelib.php');

        // Get grades as basic associative array.
        $gradeoptions = array();
        $items = \grade_item::fetch_all(array('courseid' => $course->id));
        // For some reason the fetch_all things return null if none.
        $items = $items ? $items : array();
        foreach ($items as $id => $item) {
            // Do not include grades for current item.
            if ($cm && $cm->instance == $item->iteminstance
                    && $cm->modname == $item->itemmodule
                    && $item->itemtype == 'mod') {
                continue;
            }
            $gradeoptions[$id] = $item->get_name(true);
        }
        \core_collator::asort($gradeoptions);

        // Change to JS array format and return.
        $jsarray = array();
        foreach ($gradeoptions as $id => $name) {
            $jsarray[] = (object)array('id' => $id, 'name' => $name);
        }
        return array($jsarray);
    }
}
