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
 * Simple task to run the blog cron.
 */
class blog_cron_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskblogcron', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $CFG, $DB;

        $timenow = time();
        // Run external blog cron if needed.
        if (!empty($CFG->enableblogs) && $CFG->useexternalblogs) {
            require_once($CFG->dirroot . '/blog/lib.php');
            $sql = "timefetched < ? OR timefetched = 0";
            $externalblogs = $DB->get_records_select('blog_external', $sql, array($timenow - $CFG->externalblogcrontime));

            foreach ($externalblogs as $eb) {
                blog_sync_external_entries($eb);
            }
        }
        // Run blog associations cleanup.
        if (!empty($CFG->enableblogs) && $CFG->useblogassociations) {
            require_once($CFG->dirroot . '/blog/lib.php');
            // Delete entries whose contextids no longer exists.
            $DB->delete_records_select('blog_association', 'contextid NOT IN (SELECT id FROM {context})');
        }

    }

}
