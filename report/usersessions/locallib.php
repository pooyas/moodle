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

require_once(__DIR__ . '/lib.php');

/**
 * Show user friendly duration since last activity.
 *
 * @param int $duration in seconds
 * @return string
 */
function report_usersessions_format_duration($duration) {

    // NOTE: The session duration is not accurate thanks to
    //       $CFG->session_update_timemodified_frequency setting.
    //       Also there is no point in showing days here because
    //       the session cleanup should purge all stale sessions
    //       regularly.

    if ($duration < 60) {
        return get_string('now');
    }

    if ($duration < 60 * 60 * 2) {
        $minutes = (int)($duration / 60);
        $ago = $minutes . ' ' . get_string('minutes');
        return get_string('ago', 'core_message', $ago);
    }

    $hours = (int)($duration / (60 * 60));
    $ago = $hours . ' ' . get_string('hours');
    return get_string('ago', 'core_message', $ago);
}

/**
 * Show some user friendly IP address info.
 *
 * @param string $ip
 * @return string
 */
function report_usersessions_format_ip($ip) {
    if (strpos($ip, ':') !== false) {
        // For now ipv6 is not supported yet.
        return $ip;
    }
    $url = new lion_url('/iplookup/index.php', array('ip' => $ip));
    return html_writer::link($url, $ip);
}

/**
 * Kill user session.
 *
 * @param int $id
 * @return void
 */
function report_usersessions_kill_session($id) {
    global $DB, $USER;

    $session = $DB->get_record('sessions', array('id' => $id, 'userid' => $USER->id), 'id, sid');

    if (!$session or $session->sid === session_id()) {
        // Do not delete the current session!
        return;
    }

    \core\session\manager::kill_session($session->sid);
}
