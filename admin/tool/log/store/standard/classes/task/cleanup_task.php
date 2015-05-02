<?php

/**
 * Standard log reader/writer.
 *
 * @package    logstore_standard
 * @copyright  2014 Petr Skoda {@link http://skodak.org}
 * 
 */

namespace logstore_standard\task;

defined('LION_INTERNAL') || die();

class cleanup_task extends \core\task\scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskcleanup', 'logstore_standard');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $DB;
        $loglifetime = (int)get_config('logstore_standard', 'loglifetime');

        if ($loglifetime > 0) {
            $loglifetime = time() - ($loglifetime * 3600 * 24); // Value in days.
            $DB->delete_records_select("logstore_standard_log", "timecreated < ?", array($loglifetime));
            mtrace(" Deleted old log records from standard store.");
        }
    }
}
