<?php


/**
 * Ajax point of entry for messaging API.
 *
 * @package    core
 * @subpackage message
 * @copyright  2015 Pooya Saeedi
 */

define('AJAX_SCRIPT', true);

require('../config.php');
require_once($CFG->libdir . '/filelib.php');
require_once(__DIR__ . '/lib.php');

// Only real logged in users.
require_login(null, false, null, true, true);
if (isguestuser()) {
    throw new require_login_exception();
}

// Messaging needs to be enabled.
if (empty($CFG->messaging)) {
    throw new lion_exception('disabled', 'core_message');
}

require_sesskey();
$action = optional_param('action', null, PARAM_ALPHA);
$response = null;

switch ($action) {

    // Sending a message.
    case 'sendmessage':

        require_capability('lion/site:sendmessage', context_system::instance());

        $userid = required_param('userid', PARAM_INT);
        if (empty($userid) || isguestuser($userid) || $userid == $USER->id) {
            // Cannot send messags to self, nobody or a guest.
            throw new coding_exception('Invalid user to send the message to');
        }

        $message = required_param('message', PARAM_RAW);
        $user2 = core_user::get_user($userid);
        $messageid = message_post_message($USER, $user2, $message, FORMAT_LION);

        if (!$messageid) {
            throw new lion_exception('errorwhilesendingmessage', 'core_message');
        }

        $response = array();
        break;
}

if ($response !== null) {
    echo json_encode($response);
    exit();
}

throw new coding_exception('Invalid request');
