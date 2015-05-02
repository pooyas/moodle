<?php

/**
 * The mod_imscp course module viewed event.
 *
 * @package    mod_imscp
 * @since      Lion 2.7
 * @copyright  2014 Mark Nelson <markn@lion.com>
 * 
 */

namespace mod_imscp\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_imscp course module viewed event class.
 *
 * @package    mod_imscp
 * @since      Lion 2.7
 * @copyright  2014 Mark Nelson <markn@lion.com>
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
