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
 * Simple task to delete user accounts for users who have not completed their profile in time.
 */
class delete_incomplete_users_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskdeleteincompleteusers', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $CFG, $DB;

        $timenow = time();

        // Delete users who haven't completed profile within required period.
        if (!empty($CFG->deleteincompleteusers)) {
            $cuttime = $timenow - ($CFG->deleteincompleteusers * 3600);
            $rs = $DB->get_recordset_sql ("SELECT *
                                               FROM {user}
                                           WHERE confirmed = 1 AND lastaccess > 0
                                               AND lastaccess < ? AND deleted = 0
                                               AND (lastname = '' OR firstname = '' OR email = '')",
                                           array($cuttime));
            foreach ($rs as $user) {
                if (isguestuser($user) or is_siteadmin($user)) {
                    continue;
                }
                delete_user($user);
                mtrace(" Deleted not fully setup user $user->username ($user->id)");
            }
            $rs->close();
        }
    }

}
