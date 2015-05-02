<?php

/**
 * Group updated event.
 *
 * @package    core_group
 * @copyright  2013 Frédéric Massart
 * 
 */

namespace core\event;
defined('LION_INTERNAL') || die();

/**
 * Group updated event class.
 *
 * @package    core
 * @since      Lion 2.6
 * @copyright  2013 Frédéric Massart
 * 
 */
class group_updated extends base {

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated the group with id '$this->objectid'.";
    }

    /**
     * Legacy event data if get_legacy_eventname() is not empty.
     *
     * @return \stdClass
     */
    protected function get_legacy_eventdata() {
        return $this->get_record_snapshot('groups', $this->objectid);
    }

    /**
     * Return the legacy event name.
     *
     * @return string
     */
    public static function get_legacy_eventname() {
        return 'groups_group_updated';
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventgroupupdated', 'group');
    }

    /**
     * Get URL related to the action
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/group/group.php', array('id' => $this->objectid));
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'groups';
    }
}
