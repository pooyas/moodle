<?php

/**
 * Googledocs repository upgrade script.
 *
 * @package   repository_googledocs
 * @copyright 2013 Dan Poltawski <dan@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Inform admins about setup required for googledocs change.
 */
function repository_googledocs_admin_upgrade_notification() {
    $admins = get_admins();

    if (empty($admins)) {
        return;
    }

    $a = new stdClass;
    $a->docsurl = get_docs_url('Google_OAuth_2.0_setup');
    foreach ($admins as $admin) {
        $message = new stdClass();
        $message->component         = 'lion';
        $message->name              = 'notices';
        $message->userfrom          = get_admin();
        $message->userto            = $admin;
        $message->smallmessage      = get_string('oauth2upgrade_message_small', 'repository_googledocs');
        $message->subject           = get_string('oauth2upgrade_message_subject', 'repository_googledocs');
        $message->fullmessage       = get_string('oauth2upgrade_message_content', 'repository_googledocs', $a);
        $message->fullmessagehtml   = get_string('oauth2upgrade_message_content', 'repository_googledocs', $a);
        $message->fullmessageformat = FORMAT_PLAIN;
        $message->notification      = 1;
        message_send($message);
    }
}
