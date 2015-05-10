<?php

/**
 * rss/file.php - entry point to serve rss streams
 *
 * This script simply checks the parameters to construct a $USER
 * then finds and calls a function in the relevant component to
 * actually check security and create the RSS stream
 *
 * @package    core
 * @subpackage rss
 * @copyright  2015 Pooya Saeedi
 * 
 */

/** NO_DEBUG_DISPLAY - bool, Disable lion debug and error messages. Set to false to see any errors during RSS generation */
define('NO_DEBUG_DISPLAY', true);

/** NO_LION_COOKIES - bool, Disable the use of sessions/cookies - we recreate $USER for every call. */
define('NO_LION_COOKIES', true);

require_once('../config.php');
require_once($CFG->libdir.'/filelib.php');
require_once($CFG->libdir.'/rsslib.php');

// RSS feeds must be enabled site-wide.
if (empty($CFG->enablerssfeeds)) {
    debugging('DISABLED (admin variables)');
    rss_error();
}

// All the arguments are in the path.
$relativepath = get_file_argument();
if (!$relativepath) {
    rss_error();
}

// Extract relative path components into variables.
$args = explode('/', trim($relativepath, '/'));
if (count($args) < 5) {
    rss_error();
}

$contextid   = (int)$args[0];
$token  = clean_param($args[1], PARAM_ALPHANUM);
$componentname = clean_param($args[2], PARAM_FILE);

// Check if they have requested a 1.9 RSS feed.
// If token is an int it is a user id (1.9 request).
// If token contains any letters it is a token (2.0 request).
$inttoken = intval($token);
if ($token === "$inttoken") {
    // They have requested a feed using a 1.9 url. redirect them to the 2.0 url using the guest account.

    $instanceid  = clean_param($args[3], PARAM_INT);

    // 1.9 URL puts course id where the context id is in 2.0 URLs.
    $courseid = $contextid;
    unset($contextid);

    // Find the context id.
    if ($course = $DB->get_record('course', array('id' => $courseid))) {
        $modinfo = get_fast_modinfo($course);

        foreach ($modinfo->get_instances_of($componentname) as $modinstanceid => $cm) {
            if ($modinstanceid == $instanceid) {
                $context = context_module::instance($cm->id, IGNORE_MISSING);
                break;
            }
        }
    }

    if (empty($context)) {
        // This shouldnt happen. something bad is going on.
        rss_error('rsserror');
    }

    // Make sure that $CFG->siteguest is set.
    if (empty($CFG->siteguest)) {
        if (!$guestid = $DB->get_field('user', 'id', array('username' => 'guest', 'mnethostid' => $CFG->mnet_localhost_id))) {
            // Guest does not exist yet, weird.
            rss_error('rsserror');
        }
        set_config('siteguest', $guestid);
    }
    $guesttoken = rss_get_token($CFG->siteguest);

    // Change forum to mod_forum (for example).
    $componentname = 'mod_'.$componentname;

    $url = $PAGE->url;
    $url->set_slashargument("/{$context->id}/$guesttoken/$componentname/$instanceid/rss.xml");

    // Redirect to the 2.0 rss URL.
    redirect($url);
} else {
    // Authenticate the user from the token.
    $userid = rss_get_userid_from_token($token);
    if (!$userid) {
        rss_error('rsserrorauth');
    }
}

// Check the context actually exists.
list($context, $course, $cm) = get_context_info_array($contextid);

$PAGE->set_context($context);

$user = get_complete_user_data('id', $userid);

// Let enrol plugins deal with new enrolments if necessary.
enrol_check_plugins($user);

\core\session\manager::set_user($user); // For login and capability checks.

try {
    $autologinguest = true;
    $setwantsurltome = true;
    $preventredirect = true;
    require_login($course, $autologinguest, $cm, $setwantsurltome, $preventredirect);
} catch (Exception $e) {
    if (isguestuser()) {
        rss_error('rsserrorguest');
    } else {
        rss_error('rsserrorauth');
    }
}

// Work out which component in Lion we want (from the frankenstyle name).
$componentdir = core_component::get_component_directory($componentname);
list($type, $plugin) = core_component::normalize_component($componentname);

// Call the component to check/update the feed and tell us the path to the cached file.
$pathname = null;

if (file_exists($componentdir)) {
    require_once("$componentdir/rsslib.php");
    $functionname = $plugin.'_rss_get_feed';

    if (function_exists($functionname)) {
        // The $pathname will be null if there was a problem (eg user doesn't have the necessary capabilities).
        // NOTE:the component providing the feed must do its own capability checks and security.
        try {
            $pathname = $functionname($context, $args);
        } catch (Exception $e) {
            rss_error('rsserror');
        }
    }
}

// Check that file exists.
if (empty($pathname) || !file_exists($pathname)) {
    rss_error();
}

// Send the RSS file to the user!
send_file($pathname, 'rss.xml', 3600);   // Cached by browsers for 1 hour.

/**
 * Sends an error formatted as an rss file and then exits
 *
 * @package core_rss
 * @category rss
 *
 * @param string $error the error type, default is rsserror
 * @param string $filename the name of the file to create (NOT USED)
 * @param int $lifetime UNSURE (NOT USED)
 * @uses exit
 */
function rss_error($error='rsserror', $filename='rss.xml', $lifetime=0) {
    send_file(rss_geterrorxmlfile($error), $filename, $lifetime, false, true);
    exit;
}
