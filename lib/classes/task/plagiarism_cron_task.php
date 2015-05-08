<?php

/**
 * A scheduled task.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */
namespace core\task;

/**
 * Simple task to run the plagiarism cron.
 */
class plagiarism_cron_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskplagiarismcron', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $CFG;

        require_once($CFG->libdir.'/plagiarismlib.php');
        plagiarism_cron();
    }

}
