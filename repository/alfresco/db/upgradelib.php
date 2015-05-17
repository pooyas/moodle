<?php


/**
 * Locallib.
 *
 * @package    repository
 * @subpackage alfresco
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Send a message to the admin in regard with the APIv1 migration.
 *
 * @return void
 */
function repository_alfresco_admin_security_key_notice() {
    $admins = get_admins();

    if (empty($admins)) {
        return;
    }

    foreach ($admins as $admin) {
        $message = new stdClass();
        $message->component         = 'lion';
        $message->name              = 'notices';
        $message->userfrom          = get_admin();
        $message->userto            = $admin;
        $message->smallmessage      = get_string('security_key_notice_message_small', 'repository_alfresco');
        $message->subject           = get_string('security_key_notice_message_subject', 'repository_alfresco');
        $message->fullmessage       = get_string('security_key_notice_message_content', 'repository_alfresco');
        $message->fullmessagehtml   = get_string('security_key_notice_message_content', 'repository_alfresco');
        $message->fullmessageformat = FORMAT_PLAIN;
        $message->notification      = 1;
        message_send($message);
    }
}
