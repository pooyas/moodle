<?php


/**
 * Installation code for the email message processor
 *
 * @package    message
 * @subpackage output
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Install the email message processor
 */
function xmldb_message_email_install() {
    global $DB;
    $result = true;

    $provider = new stdClass();
    $provider->name  = 'email';
    $DB->insert_record('message_processors', $provider);
    return $result;
}
