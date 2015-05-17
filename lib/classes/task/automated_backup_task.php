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
 * Simple task to run the backup cron.
 */
class automated_backup_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskautomatedbackup', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $CFG;

        // Run automated backups if required - these may take a long time to execute.
        require_once($CFG->dirroot.'/backup/util/includes/backup_includes.php');
        require_once($CFG->dirroot.'/backup/util/helper/backup_cron_helper.class.php');
        \backup_cron_automated_helper::run_automated_backup();
    }

}
