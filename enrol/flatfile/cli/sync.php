<?php

/**
 * Flatfile CLI tool.
 *
 * Notes:
 *   - it is required to use the web server account when executing PHP CLI scripts
 *   - you need to change the "www-data" to match the apache user account
 *   - use "su" if "sudo" not available
 *
 * @package    enrol_flatfile
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
        "Process flat file enrolments, update expiration and send notifications.

Options:
-v, --verbose         Print verbose progress information
-h, --help            Print out this help

Example:
\$ sudo -u www-data /usr/bin/php enrol/flatfile/cli/sync.php
";

    echo $help;
    die;
}

if (!enrol_is_enabled('flatfile')) {
    cli_error('enrol_flatfile plugin is disabled, synchronisation stopped', 2);
}

/** @var $plugin enrol_flatfile_plugin */
$plugin = enrol_get_plugin('flatfile');

if (empty($options['verbose'])) {
    $trace = new null_progress_trace();
} else {
    $trace = new text_progress_trace();
}

$result = $plugin->sync($trace);

exit($result);
