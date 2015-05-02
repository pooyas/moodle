<?php

/**
 * Log store writer interface.
 *
 * @package    tool_log
 * @copyright  2013 Petr Skoda {@link http://skodak.org}
 * 
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
