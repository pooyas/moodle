<?php

/**
 * Airnotifier message processor installation code
 *
 * @package    message_airnotifier
 * @copyright  2012 Jerome Mouneyrac
 * 
 */

/**
 * Install the Airnotifier message processor
 */
function xmldb_message_airnotifier_install() {
    global $CFG, $DB;

    $result = true;

    $provider = new stdClass();
    $provider->name = 'airnotifier';
    $provider->enabled = 0;
    $DB->insert_record('message_processors', $provider);

    return $result;
}
