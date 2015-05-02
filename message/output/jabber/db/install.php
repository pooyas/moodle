<?php

/**
 * Jabber message processor installation code
 *
 * @package    message_jabber
 * @copyright  2009 Dongsheng Cai <dongsheng@lion.com>
 * 
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
