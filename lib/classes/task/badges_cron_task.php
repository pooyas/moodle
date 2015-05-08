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
 * Simple task to run the badges cron.
 */
class badges_cron_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskbadgescron', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $CFG;
        // Run badges review cron.
        require_once($CFG->dirroot . '/badges/cron.php');
        badge_cron();
    }

}
