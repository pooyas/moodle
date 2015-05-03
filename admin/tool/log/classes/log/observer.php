<?php

/**
 * Event observer.
 *
 * @package    tool
 * @subpackage log
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace tool_log\log;

defined('LION_INTERNAL') || die();

class observer {
    /**
     * Redirect all events to this log manager, but only if this
     * log manager is actually used.
     *
     * @param \core\event\base $event
     */
    public static function store(\core\event\base $event) {
        $logmanager = get_log_manager();
        if (get_class($logmanager) === 'tool_log\log\manager') {
            /** @var \tool_log\log\manager $logmanager */
            $logmanager->process($event);
        }
    }
}
