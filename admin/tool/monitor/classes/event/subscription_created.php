<?php


/**
 * The tool_monitor subscription created event.
 *
 * @package    admin_tool
 * @subpackage monitor
 * @copyright  2015 Pooya Saeedi
 */

namespace tool_monitor\event;

defined('LION_INTERNAL') || die();

/**
 * The tool_monitor subscription created event class.
 *
 */
class subscription_created extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['objecttable'] = 'tool_monitor_subscriptions';
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventsubcreated', 'tool_monitor');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' created the event monitor subscription with id '$this->objectid'.";
    }
}
