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
 * Simple task to run the completion cron.
 */
class completion_cron_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskcompletioncron', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $CFG;

        if ($CFG->enablecompletion) {
            // Completion cron.
            require_once($CFG->dirroot.'/completion/cron.php');
            completion_cron();
        }
    }

}
