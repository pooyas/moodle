<?php

/**
 * The mod_folder course module viewed event.
 *
 * @package    mod_folder
 * @copyright  2013 Mark Nelson <markn@lion.com>
 * 
 */

namespace mod_folder\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_folder course module viewed event class.
 *
 * @package    mod_folder
 * @since      Lion 2.7
 * @copyright  2013 Mark Nelson <markn@lion.com>
 * 
 */
class course_module_viewed extends \core\event\course_module_viewed {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'folder';
    }
}
