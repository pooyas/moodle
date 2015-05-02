<?php

/**
 * Request access key to AirNotifier
 *
 * @package    message_airnotifier
 * @copyright  2012 Jerome Mouneyrac
 * 
 */

require('../../../config.php');
require_once($CFG->dirroot . '/' . $CFG->admin . '/registration/lib.php');

define('AIRNOTIFIER_PUBLICURL', 'https://messages.lion.net');

$PAGE->set_url(new lion_url('/message/output/airnotifier/requestaccesskey.php'));
$PAGE->set_context(context_system::instance());

require_login();
require_sesskey();
require_capability('lion/site:config', context_system::instance());

$strheading = get_string('requestaccesskey', 'message_airnotifier');
$PAGE->navbar->add(get_string('administrationsite'));
$PAGE->navbar->add(get_string('plugins', 'admin'));
$PAGE->navbar->add(get_string('messageoutputs', 'message'));
$returl = new lion_url('/admin/settings.php', array('section' => 'messagesettingairnotifier'));
$PAGE->navbar->add(get_string('pluginname', 'message_airnotifier'), $returl);
$PAGE->navbar->add($strheading);

$PAGE->set_heading($strheading);
$PAGE->set_title($strheading);

$msg = "";

// If we are requesting a key to the official message system, verify first that this site is registered.
// This check is also done in Airnotifier.
if (strpos($CFG->airnotifierurl, AIRNOTIFIER_PUBLICURL) !== false ) {
    $registrationmanager = new registration_manager();
    if (!$registrationmanager->get_registeredhub(HUB_LIONORGHUBURL)) {
        $msg = get_string('sitemustberegistered', 'message_airnotifier');
        $msg .= $OUTPUT->continue_button($returl);

        echo $OUTPUT->header();
        echo $OUTPUT->box($msg, 'generalbox');
        echo $OUTPUT->footer();
        die;
    }
}

$manager = new message_airnotifier_manager();

if ($key = $manager->request_accesskey()) {
    set_config('airnotifieraccesskey', $key);
    $msg = get_string('keyretrievedsuccessfully', 'message_airnotifier');
} else {
    $msg = get_string('errorretrievingkey', 'message_airnotifier');
}

$msg .= $OUTPUT->continue_button($returl);

echo $OUTPUT->header();
echo $OUTPUT->box($msg, 'generalbox ');
echo $OUTPUT->footer();
