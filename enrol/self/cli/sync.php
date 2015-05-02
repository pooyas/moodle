<?php

/**
 * CLI update for self enrolments, use for debugging or immediate update
 * of all courses.
 *
 * Notes:
 *   - it is required to use the web server account when executing PHP CLI scripts
 *   - you need to change the "www-data" to match the apache user account
 *   - use "su" if "sudo" not available
 *
 * @package    enrol_self
 * @copyright  2012 Petr Skoda {@link http://skodak.org}
 * 
 */

define('CLI_SCRIPT', true);

require(__DIR__.'/../../../config.php');
require_once("$CFG->libdir/clilib.php");

// Now get cli options.
list($options, $unrecognized) = cli_get_params(array('verbose'=>false, 'help'=>false), array('v'=>'verbose', 'h'=>'help'));

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized));
}

if ($options['help']) {
    $help =
        "Execute self course enrol updates.

Options:
-v, --verbose         Print verbose progress information
-h, --help            Print out this help

Example:
\$ sudo -u www-data /usr/bin/php enrol/self/cli/sync.php
";

    echo $help;
    die;
}

if (!enrol_is_enabled('self')) {
    cli_error('enrol_self plugin is disabled, synchronisation stopped', 2);
}

if (empty($options['verbose'])) {
    $trace = new null_progress_trace();
} else {
    $trace = new text_progress_trace();
}

/** @var $plugin enrol_self_plugin */
$plugin = enrol_get_plugin('self');

$result = $plugin->sync($trace, null);
$plugin->send_expiry_notifications($trace);

exit($result);
