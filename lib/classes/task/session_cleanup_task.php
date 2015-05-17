<?php


/**
 * Scheduled task abstract class.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */
namespace core\task;

/**
 * Simple task to cleanup user sessions from a scheduled task.
 */
class session_cleanup_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('tasksessioncleanup', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $DB;

        $timenow = time();

        \core\session\manager::gc();

        // Cleanup old session linked tokens.
        // Deletes the session linked tokens that are over a day old.
        $DB->delete_records_select('external_tokens', 'lastaccess < :onedayago AND tokentype = :tokentype',
                        array('onedayago' => $timenow - DAYSECS, 'tokentype' => EXTERNAL_TOKEN_EMBEDDED));
    }

}
