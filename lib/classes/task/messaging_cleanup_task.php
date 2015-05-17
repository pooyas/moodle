<?php


/**
 * A scheduled task.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */
namespace core\task;

/**
 * Simple task to delete old messaging records.
 */
class messaging_cleanup_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskmessagingcleanup', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $CFG, $DB;

        $timenow = time();

        // Cleanup messaging.
        if (!empty($CFG->messagingdeletereadnotificationsdelay)) {
            $notificationdeletetime = $timenow - $CFG->messagingdeletereadnotificationsdelay;
            $params = array('notificationdeletetime' => $notificationdeletetime);
            $DB->delete_records_select('message_read', 'notification=1 AND timeread<:notificationdeletetime', $params);
        }

    }

}
