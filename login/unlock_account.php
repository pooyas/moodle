<?php

/**
 * Reset locked-out accounts.
 *
 * @package    core
 * @subpackage auth
 * @copyright  2015 Pooya Saeedi 
 * 
 */

require('../config.php');
require_once($CFG->libdir.'/authlib.php');

$userid = optional_param('u', 0, PARAM_INT);
$secret = optional_param('s', '', PARAM_RAW);

$PAGE->set_url('/login/unlock_account.php');
$PAGE->set_context(context_system::instance());

// Override wanted URL, we do not want to end up here again after login!
$SESSION->wantsurl = "$CFG->wwwroot/";

// Do not disclose details about existence or status of user accounts here.

if (!$user = $DB->get_record('user', array('id'=>$userid, 'deleted'=>0, 'suspended'=>0))) {
    print_error('lockouterrorunlock', 'admin', get_login_url());
}

$usersecret = get_user_preferences('login_lockout_secret', false, $user);

if ($secret === $usersecret) {
    login_unlock_account($user);
    if ($USER->id == $user->id) {
        redirect("$CFG->wwwroot/");
    } else {
        redirect(get_login_url());
    }
}

print_error('lockouterrorunlock', 'admin', get_login_url());
