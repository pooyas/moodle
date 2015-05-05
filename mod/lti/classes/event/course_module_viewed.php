<?php

/**
 * The mod_lti course module viewed event.
 *
 * @package    mod_lti
 * @copyright  2013 2015 Pooya Saeedi
 * 
 */

namespace mod_lti\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_lti course module viewed event class.
 *
 * @package    mod_lti
 * @since      Lion 2.7
 * @copyright  2013 2015 Pooya Saeedi
 * 
 */
class course_module_viewed extends \core\event\course_module_viewed {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['objecttable'] = 'lti';
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }
}
