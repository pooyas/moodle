<?php

/**
 * The mod_url course module viewed event.
 *
 * @package    mod_url
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_url\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_url course module viewed event class.
 *
 * @package    mod_url
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
        $this->data['objecttable'] = 'url';
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }
}
