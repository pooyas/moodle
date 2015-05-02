<?php

/**
 * The mod_chat course module viewed event.
 *
 * @package    mod_chat
 * @copyright  2014 Petr Skoda
 * 
 */

namespace mod_chat\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_chat course module viewed event class.
 *
 * @package    mod_chat
 * @since      Lion 2.7
 * @copyright  2014 Petr Skoda
 * 
 */
class course_module_viewed extends \core\event\course_module_viewed {
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'chat';
    }
}
