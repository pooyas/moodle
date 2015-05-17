<?php


/**
 * The tool_monitor rule deleted event.
 *
 * @package    admin_tool
 * @subpackage monitor
 * @copyright  2015 Pooya Saeedi
 */

namespace tool_monitor\event;

defined('LION_INTERNAL') || die();

/**
 * The tool_monitor rule deleted event class.
 *
 */
class rule_deleted extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['objecttable'] = 'tool_monitor_rules';
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventruledeleted', 'tool_monitor');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' deleted the event monitor rule with id '$this->objectid'.";
    }

    /**
     * Get URL related to the action
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/admin/tool/monitor/managerules.php', array('courseid' => $this->courseid));
    }
}
