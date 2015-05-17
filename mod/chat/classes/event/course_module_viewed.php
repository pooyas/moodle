<?php


/**
 * The mod_chat course module viewed event.
 *
 * @package    mod
 * @subpackage chat
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_chat\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_chat course module viewed event class.
 *
 */
class course_module_viewed extends \core\event\course_module_viewed {
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'chat';
    }
}
