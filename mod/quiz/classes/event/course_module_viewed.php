<?php

/**
 * The mod_quiz course module viewed event.
 *
 * @package    mod
 * @subpackage quiz
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_quiz\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_quiz course module viewed event class.
 *
 */
class course_module_viewed extends \core\event\course_module_viewed {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'quiz';
    }
}
