<?php

/**
 * Observer handling events.
 *
 * @package    availability
 * @subpackage grade
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace availability_grade;

defined('LION_INTERNAL') || die();

/**
 * Callbacks handling grade changes (to clear cache).
 *
 * This ought to use the hooks system, but it doesn't exist - calls are
 * hard-coded. (The new event system is not suitable for this type of use.)
 *
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
