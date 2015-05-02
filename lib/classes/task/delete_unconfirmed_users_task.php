<?php

/**
 * Scheduled task abstract class.
 *
 * @package    core
 * @copyright  2013 onwards Martin Dougiamas  http://dougiamas.com
 * 
 */
namespace core\task;

/**
 * Simple task to delete user accounts for users who have not confirmed in time.
 */
class delete_unconfirmed_users_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskdeleteunconfirmedusers', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $CFG, $DB;

        $timenow = time();

        // Delete users who haven't confirmed within required period.
        if (!empty($CFG->deleteunconfirmed)) {
            $cuttime = $timenow - ($CFG->deleteunconfirmed * 3600);
            $rs = $DB->get_recordset_sql ("SELECT *
                                             FROM {user}
                                            WHERE confirmed = 0 AND firstaccess > 0
                                                  AND firstaccess < ? AND deleted = 0", array($cuttime));
            foreach ($rs as $user) {
                delete_user($user); // We MUST delete user properly first.
                $DB->delete_records('user', array('id' => $user->id)); // This is a bloody hack, but it might work.
                mtrace(" Deleted unconfirmed user for ".fullname($user, true)." ($user->id)");
            }
            $rs->close();
        }
    }

}
