<?php

/**
 * Picasa portfolio upgrade script.
 *
 * @package   portfolio_picasa
 * @copyright 2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Inform admins about setup required for picasa change.
 */
function portfolio_picasa_admin_upgrade_notification() {
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
        $message->smallmessage      = get_string('oauth2upgrade_message_small', 'portfolio_picasa');
        $message->subject           = get_string('oauth2upgrade_message_subject', 'portfolio_picasa');
        $message->fullmessage       = get_string('oauth2upgrade_message_content', 'portfolio_picasa', $a);
        $message->fullmessagehtml   = get_string('oauth2upgrade_message_content', 'portfolio_picasa', $a);
        $message->fullmessageformat = FORMAT_PLAIN;
        $message->notification      = 1;
        message_send($message);
    }
}
