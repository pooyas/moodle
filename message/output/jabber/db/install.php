<?php


/**
 * Jabber message processor installation code
 *
 * @package    message
 * @subpackage output
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Install the Jabber message processor
 */
function xmldb_message_jabber_install(){
    global $DB;

    $result = true;

    $provider = new stdClass();
    $provider->name  = 'jabber';
    $DB->insert_record('message_processors', $provider);
    return $result;
}
