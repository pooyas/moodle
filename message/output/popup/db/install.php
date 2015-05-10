<?php

/**
 * Installation code for the popup message processor
 *
 * @package   message
 * @subpackage popup
 * @copyright 2015 Pooya Saeedi
 * 
 */

/**
 * Install the popup message processor
 */
function xmldb_message_popup_install() {
    global $DB;

    $result = true;

    $provider = new stdClass();
    $provider->name  = 'popup';
    $DB->insert_record('message_processors', $provider);
    return $result;
}
