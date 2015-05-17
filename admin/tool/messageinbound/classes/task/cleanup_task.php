<?php


/**
 * A scheduled task to handle cleanup of old, unconfirmed e-mails.
 *
 * @category   task
 * @package    admin_tool
 * @subpackage messageinbound
 * @copyright  2015 Pooya Saeedi
 */

namespace tool_messageinbound\task;

defined('LION_INTERNAL') || die();

/**
 * A scheduled task to handle cleanup of old, unconfirmed e-mails.
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
