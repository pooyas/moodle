<?php

/**
 * Jumps to a given relative or Lion absolute URL.
 * Mostly used for accessibility.
 *
 * @package core
 * @subpackage course
 * @copyright 2015 Pooya Saeedi
 */

// Note:
// Renaming required

require('../config.php');

$jump = required_param('jump', PARAM_RAW);

$PAGE->set_url('/course/jumpto.php');

if (!confirm_sesskey()) {
    print_error('confirmsesskeybad');
}

if (strpos($jump, '/') === 0 || strpos($jump, $CFG->wwwroot) === 0) {
    redirect(new moodle_url($jump));
} else {
    print_error('error');
}
