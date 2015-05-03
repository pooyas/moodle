<?php

/**
 * This file is part of the User section Lion
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * 
 * @package core_user
 */

require_once('../config.php');
require_once($CFG->libdir.'/filelib.php');
require_once($CFG->libdir.'/resourcelib.php');

$agree = optional_param('agree', 0, PARAM_BOOL);

$PAGE->set_url('/user/policy.php');
$PAGE->set_popup_notification_allowed(false);

if (!isloggedin()) {
    require_login();
}

if (isguestuser()) {
    $sitepolicy = $CFG->sitepolicyguest;
} else {
    $sitepolicy = $CFG->sitepolicy;
}

if (!empty($SESSION->wantsurl)) {
    $return = $SESSION->wantsurl;
} else {
    $return = $CFG->wwwroot.'/';
}

if (empty($sitepolicy)) {
    // Nothing to agree to, sorry, hopefully we will not get to infinite loop.
    redirect($return);
}

if ($agree and confirm_sesskey()) {    // User has agreed.
    if (!isguestuser()) {              // Don't remember guests.
        $DB->set_field('user', 'policyagreed', 1, array('id' => $USER->id));
    }
    $USER->policyagreed = 1;
    unset($SESSION->wantsurl);
    redirect($return);
}

$strpolicyagree = get_string('policyagree');
$strpolicyagreement = get_string('policyagreement');
$strpolicyagreementclick = get_string('policyagreementclick');

$PAGE->set_context(context_system::instance());
$PAGE->set_title($strpolicyagreement);
$PAGE->set_heading($SITE->fullname);
$PAGE->navbar->add($strpolicyagreement);

echo $OUTPUT->header();
echo $OUTPUT->heading($strpolicyagreement);

$mimetype = mimeinfo('type', $sitepolicy);
if ($mimetype == 'document/unknown') {
    // Fallback for missing index.php, index.html.
    $mimetype = 'text/html';
}

// We can not use our popups here, because the url may be arbitrary, see MDL-9823.
$clicktoopen = '<a href="'.$sitepolicy.'" onclick="this.target=\'_blank\'">'.$strpolicyagreementclick.'</a>';

echo '<div class="noticebox">';
echo resourcelib_embed_general($sitepolicy, $strpolicyagreement, $clicktoopen, $mimetype);
echo '</div>';

$formcontinue = new single_button(new lion_url('policy.php', array('agree' => 1)), get_string('yes'));
$formcancel = new single_button(new lion_url($CFG->wwwroot.'/login/logout.php', array('agree' => 0)), get_string('no'));
echo $OUTPUT->confirm($strpolicyagree, $formcontinue, $formcancel);

echo $OUTPUT->footer();

