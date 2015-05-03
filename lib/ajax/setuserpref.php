<?php

/**
 * Code to update a user preference in response to an ajax call.
 *
 * You should not send requests to this script directly. Instead use the set_user_preference
 * function in javascript_static.js.
 *
 * @package    core
 * @category   preference
 * @copyright  2015 Pooya Saeedi
 * 
 */

require_once(dirname(__FILE__) . '/../../config.php');

// Check access.
if (!confirm_sesskey()) {
    print_error('invalidsesskey');
}

// Get the name of the preference to update, and check it is allowed.
$name = required_param('pref', PARAM_RAW);
if (!isset($USER->ajax_updatable_user_prefs[$name])) {
    print_error('notallowedtoupdateprefremotely');
}

// Get and the value.
$value = required_param('value', $USER->ajax_updatable_user_prefs[$name]);

// Update
if (!set_user_preference($name, $value)) {
    print_error('errorsettinguserpref');
}

echo 'OK';
