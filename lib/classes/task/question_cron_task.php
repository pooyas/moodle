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
 * Simple task to run the question cron.
 */
class question_cron_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskquestioncron', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $CFG;

        // Run question bank clean-up.
        require_once($CFG->libdir . '/questionlib.php');
        \question_bank::cron();

    }

}
