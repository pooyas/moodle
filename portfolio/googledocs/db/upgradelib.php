<?php

/**
 * Googledocs portfolio upgrade script.
 *
 * @package   portfolio_googledocs
 * @copyright 2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Inform admins about setup required for googledocs change.
 */
function portfolio_googledocs_admin_upgrade_notification() {
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
        $message->smallmessage      = get_string('oauth2upgrade_message_small', 'portfolio_googledocs');
        $message->subject           = get_string('oauth2upgrade_message_subject', 'portfolio_googledocs');
        $message->fullmessage       = get_string('oauth2upgrade_message_content', 'portfolio_googledocs', $a);
        $message->fullmessagehtml   = get_string('oauth2upgrade_message_content', 'portfolio_googledocs', $a);
        $message->fullmessageformat = FORMAT_PLAIN;
        $message->notification      = 1;
        message_send($message);
    }
}
