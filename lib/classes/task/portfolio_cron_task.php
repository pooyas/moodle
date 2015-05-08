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
 * Simple task to run the portfolio cron.
 */
class portfolio_cron_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskportfoliocron', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $CFG;

        if ($CFG->enableportfolios) {
            require_once($CFG->libdir . '/portfoliolib.php');
            portfolio_cron();
        }
    }

}
