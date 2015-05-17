<?php


/**
 * The tool_monitor subscription deleted event.
 *
 * @package    admin_tool
 * @subpackage monitor
 * @copyright  2015 Pooya Saeedi
 */

namespace tool_monitor\event;

defined('LION_INTERNAL') || die();

/**
 * The tool_monitor subscription deleted event class.
 *
 */
class subscription_deleted extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['objecttable'] = 'tool_monitor_subscriptions';
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventsubdeleted', 'tool_monitor');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' deleted the event monitor subscription with id '$this->objectid'.";
    }
}
