<?php

/**
 * Change a users email address
 *
 * @copyright 2015 Pooya Saeedi
 * 
 * @package core_user
 */

require_once('../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot.'/user/editlib.php');
require_once($CFG->dirroot.'/user/lib.php');

$key = required_param('key', PARAM_ALPHANUM);
$id  = required_param('id', PARAM_INT);

$PAGE->set_url('/user/emailupdate.php', array('id' => $id, 'key' => $key));
$PAGE->set_context(context_system::instance());

if (!$user = $DB->get_record('user', array('id' => $id))) {
    print_error('invaliduserid');
}

$preferences = get_user_preferences(null, null, $user->id);
$a = new stdClass();
$a->fullname = fullname($user, true);
$stremailupdate = get_string('emailupdate', 'auth', $a);

$PAGE->set_title(format_string($SITE->fullname) . ": $stremailupdate");
$PAGE->set_heading(format_string($SITE->fullname) . ": $stremailupdate");

echo $OUTPUT->header();

if (empty($preferences['newemailattemptsleft'])) {
    redirect("$CFG->wwwroot/user/view.php?id=$user->id");

} else if ($preferences['newemailattemptsleft'] < 1) {
    cancel_email_update($user->id);
    $stroutofattempts = get_string('auth_outofnewemailupdateattempts', 'auth');
    echo $OUTPUT->box($stroutofattempts, 'center');

} else if ($key == $preferences['newemailkey']) {
    $olduser = clone($user);
    cancel_email_update($user->id);
    $user->email = $preferences['newemail'];

    // Detect duplicate before saving.
    if ($DB->get_record('user', array('email' => $user->email))) {
        $stremailnowexists = get_string('emailnowexists', 'auth');
        echo $OUTPUT->box($stremailnowexists, 'center');
        echo $OUTPUT->continue_button("$CFG->wwwroot/user/view.php?id=$user->id");
    } else {
        // Update user email.
        $authplugin = get_auth_plugin($user->auth);
        $authplugin->user_update($olduser, $user);
        user_update_user($user, false);
        $a->email = $user->email;
        $stremailupdatesuccess = get_string('emailupdatesuccess', 'auth', $a);
        echo $OUTPUT->box($stremailupdatesuccess, 'center');
        echo $OUTPUT->continue_button("$CFG->wwwroot/user/view.php?id=$user->id");
    }

} else {
    $preferences['newemailattemptsleft']--;
    set_user_preference('newemailattemptsleft', $preferences['newemailattemptsleft'], $user->id);
    $strinvalidkey = get_string('auth_invalidnewemailkey', 'auth');
    echo $OUTPUT->box($strinvalidkey, 'center');
}

echo $OUTPUT->footer();
