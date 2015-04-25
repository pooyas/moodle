<?php

/**
 * Serve assertion JSON by unique hash of issued badge
 *
 * @package    core
 * @subpackage badges
 * @copyright  2015 Pooya Saeedi
 */

// Note:
// Renaming required

define('AJAX_SCRIPT', true);
define('NO_MOODLE_COOKIES', true); // No need for a session here.

require_once(dirname(dirname(__FILE__)) . '/config.php');

if (empty($CFG->enablebadges)) {
    print_error('badgesdisabled', 'badges');
}

$hash = required_param('b', PARAM_ALPHANUM); // Issued badge unique hash for badge assertion.
$action = optional_param('action', null, PARAM_BOOL); // Generates badge class if true.

$assertion = new core_badges_assertion($hash);

if (!is_null($action)) {
    // Get badge class or issuer information depending on $action.
    $json = ($action) ? $assertion->get_badge_class() : $assertion->get_issuer();
} else {
    // Otherwise, get badge assertion.
    $json = $assertion->get_badge_assertion();
}


echo $OUTPUT->header();
echo json_encode($json);
