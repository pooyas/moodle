<?php


/**
 * Display details of an issued badge with criteria and evidence
 *
 * @package    core
 * @subpackage badges
 * @copyright  2015 Pooya Saeedi
 */

require_once(dirname(dirname(__FILE__)) . '/config.php');
require_once($CFG->libdir . '/badgeslib.php');

$json = optional_param('badge', null, PARAM_RAW);
// Redirect to homepage if users are trying to access external badge through old url.
if ($json) {
    redirect($CFG->wwwroot, get_string('invalidrequest', 'error'), 3);
}

$hash = required_param('hash', PARAM_ALPHANUM);
$userid = required_param('user', PARAM_INT);

$PAGE->set_url(new lion_url('/badges/external.php', array('hash' => $hash, 'user' => $userid)));

// Using the same setting as user profile page.
if (!empty($CFG->forceloginforprofiles)) {
    require_login();
    if (isguestuser()) {
        $SESSION->wantsurl = $PAGE->url->out(false);
        redirect(get_login_url());
    }
} else if (!empty($CFG->forcelogin)) {
    require_login();
}

// Get all external badges of a user.
$out = get_backpack_settings($userid);

// If we didn't find any badges then print an error.
if (is_null($out)) {
    print_error('error:externalbadgedoesntexist', 'badges');
}

$badges = $out->badges;

// The variable to store the badge we want.
$badge = '';

// Loop through the badges and check if supplied badge hash exists in user external badges.
foreach ($badges as $b) {
    if ($hash == hash("md5", $b->hostedUrl)) {
        $badge = $b;
        break;
    }
}

// If we didn't find the badge a user might be trying to replace the userid parameter.
if (empty($badge)) {
    print_error('error:externalbadgedoesntexist', 'badges');
}

$PAGE->set_context(context_system::instance());
$output = $PAGE->get_renderer('core', 'badges');

$badge = new external_badge($badge, $userid);

$PAGE->set_pagelayout('base');
$PAGE->set_title(get_string('issuedbadge', 'badges'));
$PAGE->set_heading(s($badge->issued->assertion->badge->name));
$PAGE->navbar->add(s($badge->issued->assertion->badge->name));
if (isloggedin() && $USER->id == $userid) {
    $url = new lion_url('/badges/mybadges.php');
} else {
    $url = new lion_url($CFG->wwwroot);
}
navigation_node::override_active_url($url);

echo $OUTPUT->header();

echo $output->render($badge);

echo $OUTPUT->footer();
