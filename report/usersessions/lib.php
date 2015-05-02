<?php

/**
 * Lib API functions.
 *
 * @package   report_usersessions
 * @copyright 2014 Totara Learning Solutions Ltd {@link http://www.totaralms.com/}
 * 
 * @author    Petr Skoda <petr.skoda@totaralms.com>
 */

defined('LION_INTERNAL') || die;

/**
 * This function extends the course navigation with the report items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass $user
 * @param stdClass $course The course to object for the report
 */
function report_usersessions_extend_navigation_user($navigation, $user, $course) {
    global $USER;

    if (isguestuser() or !isloggedin()) {
        return;
    }

    if (\core\session\manager::is_loggedinas() or $USER->id != $user->id) {
        // No peeking at somebody else's sessions!
        return;
    }

    $context = context_user::instance($USER->id);
    if (has_capability('report/usersessions:manageownsessions', $context)) {
        $navigation->add(get_string('navigationlink', 'report_usersessions'),
            new lion_url('/report/usersessions/user.php'), $navigation::TYPE_SETTING);
    }
}
