<?php

/**
 * A scheduled task to handle cleanup of old, unconfirmed e-mails.
 *
 * @package    tool_messageinbound
 * @category   task
 * @copyright  2014 Andrew Nicols
 * 
 */

namespace tool_messageinbound\task;

defined('LION_INTERNAL') || die();

/**
 * A scheduled task to handle cleanup of old, unconfirmed e-mails.
 *
 * @copyright  2014 Andrew Nicols
 * 
 */
class cleanup_task extends \core\task\scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskcleanup', 'tool_messageinbound');
    }

    /**
     * Execute the main Inbound Message pickup task.
     */
    public function execute() {
        $manager = new \tool_messageinbound\manager();
        return $manager->tidy_old_messages();
    }
}
