<?php

/**
 * The mod_resource course module viewed event.
 *
 * @package    mod_resource
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_resource\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_resource course module viewed event class.
 *
 * @package    mod_resource
 * @since      Lion 2.7
 * @copyright  2015 Pooya Saeedi
 * 
 */
class course_module_viewed extends \core\event\course_module_viewed {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['objecttable'] = 'resource';
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }
}
