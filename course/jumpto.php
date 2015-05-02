<?php


/**
 * Jumps to a given relative or Lion absolute URL.
 * Mostly used for accessibility.
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package course
 */

require('../config.php');

$jump = required_param('jump', PARAM_RAW);

$PAGE->set_url('/course/jumpto.php');

if (!confirm_sesskey()) {
    print_error('confirmsesskeybad');
}

if (strpos($jump, '/') === 0 || strpos($jump, $CFG->wwwroot) === 0) {
    redirect(new lion_url($jump));
} else {
    print_error('error');
}
