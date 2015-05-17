<?php


/**
 * Legacy log reader.
 *
 * @package    admin_tool
 * @subpackage log
 * @copyright  2015 Pooya Saeedi
 */

namespace logstore_legacy\task;

defined('LION_INTERNAL') || die();

class cleanup_task extends \core\task\scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskcleanup', 'logstore_legacy');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $CFG, $DB;

        // Delete old logs to save space (this might need a timer to slow it down...).
        if (!empty($CFG->loglifetime)) { // Value in days.
            $loglifetime = time(0) - ($CFG->loglifetime * 3600 * 24);
            $DB->delete_records_select("log", "time < ?", array($loglifetime));
            mtrace(" Deleted old legacy log records");
        }
    }
}
