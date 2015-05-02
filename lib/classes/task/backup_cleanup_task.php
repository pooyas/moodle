<?php

/**
 * A scheduled task.
 *
 * @package    core
 * @copyright  2013 onwards Martin Dougiamas  http://dougiamas.com
 * 
 */
namespace core\task;

/**
 * Simple task to delete old backup records.
 */
class backup_cleanup_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskbackupcleanup', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $DB;

        $timenow = time();

        // Delete old backup_controllers and logs.
        $loglifetime = get_config('backup', 'loglifetime');
        if (!empty($loglifetime)) {  // Value in days.
            $loglifetime = $timenow - ($loglifetime * 3600 * 24);
            // Delete child records from backup_logs.
            $DB->execute("DELETE FROM {backup_logs}
                           WHERE EXISTS (
                               SELECT 'x'
                                 FROM {backup_controllers} bc
                                WHERE bc.backupid = {backup_logs}.backupid
                                  AND bc.timecreated < ?)", array($loglifetime));
            // Delete records from backup_controllers.
            $DB->execute("DELETE FROM {backup_controllers}
                          WHERE timecreated < ?", array($loglifetime));
        }

    }

}
