<?php


/**
 * Handles AJAX processing (convert date to timestamp using current calendar).
 *
 * @package    availability_condition
 * @subpackage date
 * @copyright  2015 Pooya Saeedi
 */

define('AJAX_SCRIPT', true);
require(__DIR__ . '/../../../config.php');

// Action verb.
$action = required_param('action', PARAM_ALPHA);

switch ($action) {
    case 'totime':
        // Converts from time fields to timestamp using current user's calendar and time zone.
        echo \availability_date\frontend::get_time_from_fields(
                required_param('year', PARAM_INT),
                required_param('month', PARAM_INT),
                required_param('day', PARAM_INT),
                required_param('hour', PARAM_INT),
                required_param('minute', PARAM_INT));
        exit;

    case 'fromtime' :
        // Converts from timestamp to time fields.
        echo json_encode(\availability_date\frontend::get_fields_from_time(
                required_param('time', PARAM_INT)));
        exit;
}

// Unexpected actions throw coding_exception (this error should not occur
// unless there is a code bug).
throw new coding_exception('Unexpected action parameter');