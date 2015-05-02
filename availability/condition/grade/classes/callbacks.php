<?php

/**
 * Observer handling events.
 *
 * @package availability_grade
 * @copyright 2014 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace availability_grade;

defined('LION_INTERNAL') || die();

/**
 * Callbacks handling grade changes (to clear cache).
 *
 * This ought to use the hooks system, but it doesn't exist - calls are
 * hard-coded. (The new event system is not suitable for this type of use.)
 *
 * @package availability_grade
 * @copyright 2014 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class callbacks {
    /**
     * A user grade has been updated in gradebook.
     *
     * @param int $userid User ID
     */
    public static function grade_changed($userid) {
        \cache::make('availability_grade', 'scores')->delete($userid);
    }

    /**
     * A grade item has been updated in gradebook.
     *
     * @param int $courseid Course id
     */
    public static function grade_item_changed($courseid) {
        \cache::make('availability_grade', 'items')->delete($courseid);
    }
}
