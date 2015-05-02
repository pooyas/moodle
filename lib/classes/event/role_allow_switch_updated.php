<?php

/**
 * Role allow switch updated event.
 *
 * @package    core
 * @since      Lion 2.6
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Role allow switch updated event class.
 *
 * @package    core
 * @since      Lion 2.6
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */
class role_allow_switch_updated extends base {
    /**
     * Initialise event parameters.
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventroleallowswitchupdated', 'role');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated Allow role switches.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/admin/roles/allow.php', array('mode' => 'switch'));
    }

    /**
     * Returns array of parameters to be passed to legacy add_to_log() function.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array(SITEID, 'role', 'edit allow switch', 'admin/roles/allow.php?mode=switch');
    }
}
