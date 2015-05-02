<?php

/**
 * Forgot password routine.
 *
 * Finds the user and calls the appropriate routine for their authentication type.
 *
 * @package    core
 * @subpackage auth
 * @copyright  1999 onwards Martin Dougiamas  http://dougiamas.com
 * 
 */

require('../config.php');
require_once($CFG->libdir.'/authlib.php');
require_once(__DIR__ . '/lib.php');
require_once('forgot_password_form.php');
require_once('set_password_form.php');

$token = optional_param('token', false, PARAM_ALPHANUM);

//HTTPS is required in this page when $CFG->loginhttps enabled
$PAGE->https_required();

$PAGE->set_url('/login/forgot_password.php');
$systemcontext = context_system::instance();
$PAGE->set_context($systemcontext);

// setup text strings
$strforgotten = get_string('passwordforgotten');
$strlogin     = get_string('login');

$PAGE->navbar->add($strlogin, get_login_url());
$PAGE->navbar->add($strforgotten);
$PAGE->set_title($strforgotten);
$PAGE->set_heading($COURSE->fullname);

// if alternatepasswordurl is defined, then we'll just head there
if (!empty($CFG->forgottenpasswordurl)) {
    redirect($CFG->forgottenpasswordurl);
}

// if you are logged in then you shouldn't be here!
if (isloggedin() and !isguestuser()) {
    redirect($CFG->wwwroot.'/index.php', get_string('loginalready'), 5);
}

if (empty($token)) {
    // This is a new password reset request.
    // Process the request; identify the user & send confirmation email.
    core_login_process_password_reset_request();
} else {
    // User clicked on confirmation link in email message
    // validate the token & set new password
    core_login_process_password_set($token);
}
