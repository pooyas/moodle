<?php

/**
 * Log store interface.
 *
 * @package    tool
 * @subpackage log
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace tool_log\log;

defined('LION_INTERNAL') || die();

interface store {
    /**
     * Create new instance of store,
     * the calling code must make sure only one instance exists.
     *
     * @param manager $manager
     */
    public function __construct(\tool_log\log\manager $manager);

    /**
     * Notify store no more events are going to be written/read from it.
     * @return void
     */
    public function dispose();
}
