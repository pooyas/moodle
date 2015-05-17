<?php


/**
 * The mod_imscp course module viewed event.
 *
 * @package    mod
 * @subpackage imscp
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_imscp\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_imscp course module viewed event class.
 *
 */
class course_module_viewed extends \core\event\course_module_viewed {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['objecttable'] = 'imscp';
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }
}
