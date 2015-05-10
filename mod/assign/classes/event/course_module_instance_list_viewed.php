<?php

/**
 * The mod_assign instance list viewed event.
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_assign\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_assign instance list viewed event class.
 *
 */
class course_module_instance_list_viewed extends \core\event\course_module_instance_list_viewed {
    /**
     * Create the event from course record.
     *
     * @param \stdClass $course
     * @return course_module_instance_list_viewed
     */
    public static function create_from_course(\stdClass $course) {
        $params = array(
            'context' => \context_course::instance($course->id)
        );
        $event = \mod_assign\event\course_module_instance_list_viewed::create($params);
        $event->add_record_snapshot('course', $course);
        return $event;
    }
}
