<?php

/**
 * The mod_book instance list viewed event.
 *
 * @package    mod_book
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_book\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_book instance list viewed event class.
 *
 * @package    mod_book
 * @since      Lion 2.7
 * @copyright  2013 onwards Ankit Agarwal
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
        $event = \mod_book\event\course_module_instance_list_viewed::create($params);
        $event->add_record_snapshot('course', $course);
        return $event;
    }}

