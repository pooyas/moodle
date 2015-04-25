<?php

/**
 * Sends request to check web site availability.
 *
 * @package    core
 * @subpackage badges
 * @copyright  2015 Pooya Saeedi
 */

define('AJAX_SCRIPT', true);

require_once(dirname(dirname(__FILE__)) . '/config.php');
require_once($CFG->libdir . '/badgeslib.php');

require_login();
$PAGE->set_url('/badges/ajax.php');
$PAGE->set_context(context_system::instance());

// Unlock session during potentially long curl request.
\core\session\manager::write_close();

$result = badges_check_backpack_accessibility();

$outcome = new stdClass();
$outcome->code = $result;
$outcome->response = get_string('error:backpacknotavailable', 'badges') . $OUTPUT->help_icon('backpackavailability', 'badges');

echo $OUTPUT->header();
echo json_encode($outcome);

die();
