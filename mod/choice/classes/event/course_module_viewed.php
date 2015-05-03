<?php

/**
 * The mod_choice course module viewed event.
 *
 * @package mod_choice
 * @copyright 2013 Adrian Greeve <adrian@lion.com>
 * 
 */

namespace mod_choice\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_choice course module viewed event class.
 *
 * @package    mod_choice
 * @since      Lion 2.6
 * @copyright  2013 Adrian Greeve
 * 
 */
class course_module_viewed extends \core\event\course_module_viewed {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'choice';
    }
}
