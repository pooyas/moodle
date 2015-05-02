<?php

/**
 * The tool_monitor rule updated event.
 *
 * @package    tool_monitor
 * @copyright  2014 Mark Nelson <markn@lion.com>
 * 
 */

namespace tool_monitor\event;

defined('LION_INTERNAL') || die();

/**
 * The tool_monitor rule updated event class.
 *
 * @package    tool_monitor
 * @since      Lion 2.8
 * @copyright  2014 Mark Nelson <markn@lion.com>
 * 
 */
class rule_updated extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['objecttable'] = 'tool_monitor_rules';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventruleupdated', 'tool_monitor');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated the event monitor rule with id '$this->objectid'.";
    }

    /**
     * Get URL related to the action
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/admin/tool/monitor/edit.php', array('ruleid' => $this->objectid,
            'courseid' => $this->courseid));
    }
}
