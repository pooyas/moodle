<?php

/**
 * Scheduled task class.
 *
 * @package    core
 * @copyright  2013 onwards Martin Dougiamas  http://dougiamas.com
 * 
 */
namespace core\task;

/**
 * Simple task to create accounts and send password emails for new users.
 */
class send_new_user_passwords_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('tasksendnewuserpasswords', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $DB;

        // Generate new password emails for users - ppl expect these generated asap.
        if ($DB->count_records('user_preferences', array('name' => 'create_password', 'value' => '1'))) {
            mtrace('Creating passwords for new users...');
            $usernamefields = get_all_user_name_fields(true, 'u');
            $newusers = $DB->get_recordset_sql("SELECT u.id as id, u.email, u.auth, u.deleted,
                                                     u.suspended, u.emailstop, u.mnethostid, u.mailformat,
                                                     $usernamefields, u.username, u.lang,
                                                     p.id as prefid
                                                FROM {user} u
                                                JOIN {user_preferences} p ON u.id=p.userid
                                               WHERE p.name='create_password' AND p.value='1' AND
                                                     u.email !='' AND u.suspended = 0 AND
                                                     u.auth != 'nologin' AND u.deleted = 0");

            // Note: we can not send emails to suspended accounts.
            foreach ($newusers as $newuser) {
                // Use a low cost factor when generating bcrypt hash otherwise
                // hashing would be slow when emailing lots of users. Hashes
                // will be automatically updated to a higher cost factor the first
                // time the user logs in.
                if (setnew_password_and_mail($newuser, true)) {
                    unset_user_preference('create_password', $newuser);
                    set_user_preference('auth_forcepasswordchange', 1, $newuser);
                } else {
                    trigger_error("Could not create and mail new user password!");
                }
            }
            $newusers->close();
        }
    }

}
