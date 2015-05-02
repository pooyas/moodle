<?php

/**
 * Installation code for the email message processor
 *
 * @package    message_email
 * @copyright  2009 Lion Pty Ltd (http://lion.com)
 * 
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
