<?php


/**
 * Log store writer interface.
 *
 * @package    admin_tool
 * @subpackage log
 * @copyright  2015 Pooya Saeedi
 */

namespace tool_log\log;

defined('LION_INTERNAL') || die();

interface writer extends store {
    /**
     * Write one event to the store.
     *
     * @param \core\event\base $event
     * @return void
     */
    public function write(\core\event\base $event);
}
