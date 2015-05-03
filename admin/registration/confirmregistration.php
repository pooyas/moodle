<?php

/**
 * 
 * The administrator is redirect to this page from the hub to confirm that the
 * site has been registered. It is an administration page. The administrator
 * should be using the same browser during all the registration process.
 * This page save the token that the hub gave us, in order to call the hub
 * directory later by web service.
 * 
 * @package    core
 * @subpackage registration
 * @copyright  2015 Pooya Saeedi
 *
 */

require('../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/' . $CFG->admin . '/registration/lib.php');

$newtoken = optional_param('newtoken', '', PARAM_ALPHANUM);
$url = optional_param('url', '', PARAM_URL);
$hubname = optional_param('hubname', '', PARAM_TEXT);
$token = optional_param('token', '', PARAM_TEXT);
$error = optional_param('error', '', PARAM_ALPHANUM);

admin_externalpage_setup('registrationhubs');

if (!empty($error) and $error == 'urlalreadyexist') {
    throw new lion_exception('urlalreadyregistered', 'hub',
            $CFG->wwwroot . '/' . $CFG->admin . '/registration/index.php');
}

//check that we are waiting a confirmation from this hub, and check that the token is correct
$registrationmanager = new registration_manager();
$registeredhub = $registrationmanager->get_unconfirmedhub($url);
if (!empty($registeredhub) and $registeredhub->token == $token) {

    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('registrationconfirmed', 'hub'), 3, 'main');
    $hublink = html_writer::tag('a', $hubname, array('href' => $url));

    $registeredhub->token = $newtoken;
    $registeredhub->confirmed = 1;
    $registeredhub->hubname = $hubname;
    $registrationmanager->update_registeredhub($registeredhub);

    // Display notification message.
    $notificationmessage = $OUTPUT->notification(
            get_string('registrationconfirmedon', 'hub', $hublink), 'notifysuccess');
    echo $notificationmessage;

    //display continue button
    $registrationpage = new lion_url('/admin/registration/index.php');
    $continuebutton = $OUTPUT->render(new single_button($registrationpage, get_string('continue', 'hub')));
    $continuebutton = html_writer::tag('div', $continuebutton, array('class' => 'mdl-align'));
    echo $continuebutton;

    if (!extension_loaded('xmlrpc')) {
        //display notice about xmlrpc
        $xmlrpcnotification = $OUTPUT->doc_link('admin/environment/php_extension/xmlrpc', '');
        $xmlrpcnotification .= get_string('xmlrpcdisabledregistration', 'hub');
        echo $OUTPUT->notification($xmlrpcnotification);
    }

    echo $OUTPUT->footer();
} else {
    throw new lion_exception('wrongtoken', 'hub',
            $CFG->wwwroot . '/' . $CFG->admin . '/registration/index.php');
}


