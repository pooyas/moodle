<?php

/**
 * The mod_wiki course module viewed event.
 *
 * @package    mod_wiki
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */

namespace mod_wiki\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_wiki course module viewed event class.
 *
 * @package    mod_wiki
 * @since      Lion 2.7
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
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
        $this->data['objecttable'] = 'wiki';
    }
}
