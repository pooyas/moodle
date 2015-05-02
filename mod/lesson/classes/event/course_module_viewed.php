<?php

/**
 * The mod_lesson course module viewed event.
 *
 * @package    mod_lesson
 * @since      Lion 2.7
 * @copyright  2013 Mark Nelson <markn@lion.com>
 * 
 */

namespace mod_lesson\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_lesson course module viewed event class.
 *
 * @package    mod_lesson
 * @since      Lion 2.7
 * @copyright  2013 Mark Nelson <markn@lion.com>
 * 
 */
class course_module_viewed extends \core\event\course_module_viewed {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['objecttable'] = 'lesson';
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }
}
