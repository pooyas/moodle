<?php

/**
 * Locallib.
 *
 * @package    repository_boxnet
 * @copyright  2013 Frédéric Massart
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Send a message to the admin in regard with the APIv1 migration.
 *
 * @return void
 */
function repository_boxnet_admin_upgrade_notification() {
    $admins = get_admins();

    if (empty($admins)) {
        return;
    }
    $a = new stdClass();
    $a->docsurl = get_docs_url('Box.net_APIv1_migration');

    foreach ($admins as $admin) {
        $message = new stdClass();
        $message->component         = 'lion';
        $message->name              = 'notices';
        $message->userfrom          = get_admin();
        $message->userto            = $admin;
        $message->smallmessage      = get_string('apiv1migration_message_small', 'repository_boxnet');
        $message->subject           = get_string('apiv1migration_message_subject', 'repository_boxnet');
        $message->fullmessage       = get_string('apiv1migration_message_content', 'repository_boxnet', $a);
        $message->fullmessagehtml   = get_string('apiv1migration_message_content', 'repository_boxnet', $a);
        $message->fullmessageformat = FORMAT_PLAIN;
        $message->notification      = 1;
        message_send($message);
    }
}
