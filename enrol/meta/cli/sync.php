<?php


/**
 * CLI sync for meta course enrolments, use for debugging or immediate sync
 * of all courses.
 *
 * Notes:
 *   - it is required to use the web server account when executing PHP CLI scripts
 *   - you need to change the "www-data" to match the apache user account
 *   - use "su" if "sudo" not available
 *
 * @package    enrol
 * @subpackage meta
 * @copyright  2015 Pooya Saeedi
 */

define('CLI_SCRIPT', true);

require(dirname(dirname(dirname(dirname(__FILE__)))).'/config.php');
require_once($CFG->libdir.'/clilib.php');
require_once("$CFG->dirroot/enrol/meta/locallib.php");

// now get cli options
list($options, $unrecognized) = cli_get_params(array('verbose'=>false, 'help'=>false), array('v'=>'verbose', 'h'=>'help'));

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized));
}

if ($options['help']) {
    $help =
        "Execute meta course enrol sync.

Options:
-v, --verbose         Print verbose progess information
-h, --help            Print out this help

Example:
\$sudo -u www-data /usr/bin/php enrol/meta/cli/sync.php
";

    echo $help;
    die;
}

$verbose = !empty($options['verbose']);

$result = enrol_meta_sync(null, $verbose);

exit($result);