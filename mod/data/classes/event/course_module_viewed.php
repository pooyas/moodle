<?php


/**
 * The mod_data course module viewed event.
 *
 * @package    mod
 * @subpackage data
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_data\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_data course module viewed event class.
 *
 */
class course_module_viewed extends \core\event\course_module_viewed {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['objecttable'] = 'data';
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }
}
