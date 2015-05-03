<?php

/**
 * CLI script to set up all the behat test environment.
 *
 * @package    tool
 * @subpackage behat
 * @copyright  2015 Pooya Saeedi
 * 
 */

if (isset($_SERVER['REMOTE_ADDR'])) {
    die(); // No access from web!
}

// Force OPcache reset if used, we do not want any stale caches
// when preparing test environment.
if (function_exists('opcache_reset')) {
    opcache_reset();
}

// Is not really necessary but adding it as is a CLI_SCRIPT.
define('CLI_SCRIPT', true);
define('CACHE_DISABLE_ALL', true);

// Basic functions.
require_once(__DIR__ . '/../../../../lib/clilib.php');
require_once(__DIR__ . '/../../../../lib/behat/lib.php');

list($options, $unrecognized) = cli_get_params(
    array(
        'parallel' => 0,
        'maxruns'  => false,
        'help'     => false,
        'fromrun'  => 1,
        'torun'    => 0,
    ),
    array(
        'j' => 'parallel',
        'm' => 'maxruns',
        'h' => 'help',
    )
);

// Checking run.php CLI script usage.
$help = "
Behat utilities to initialise behat tests

Options:
-j, --parallel Number of parallel behat run to initialise
-m, --maxruns  Max parallel processes to be executed at one time.
--fromrun      Execute run starting from (Used for parallel runs on different vms)
--torun        Execute run till (Used for parallel runs on different vms)

-h, --help     Print out this help

Example from Lion root directory:
\$ php admin/tool/behat/cli/init.php --parallel=2

More info in http://docs.lion.org/dev/Acceptance_testing#Running_tests
";

if (!empty($options['help'])) {
    echo $help;
    exit(0);
}

// Check which util file to call.
$utilfile = 'util_single_run.php';
$paralleloption = "";
// If parallel run then use utilparallel.
if ($options['parallel']) {
    $utilfile = 'util.php';
    $paralleloption = "";
    foreach ($options as $option => $value) {
        if ($value) {
            $paralleloption .= " --$option=\"$value\"";
        }
    }
}

// Changing the cwd to admin/tool/behat/cli.
$cwd = getcwd();
$output = null;

// If behat dependencies not downloaded then do it first, else symfony/process can't be used.
if ($options['parallel'] && !file_exists(__DIR__ . "/../../../../vendor/autoload.php")) {
    $code = BEHAT_EXITCODE_COMPOSER;
} else {
    chdir(__DIR__);
    exec("php $utilfile --diag $paralleloption", $output, $code);
}

// Check if composer needs to be updated.
if (($code == BEHAT_EXITCODE_INSTALL) || $code == BEHAT_EXITCODE_REINSTALL || $code == BEHAT_EXITCODE_COMPOSER) {
    testing_update_composer_dependencies();
}

if ($code == 0) {
    echo "Behat test environment already installed\n";

} else if ($code == BEHAT_EXITCODE_INSTALL) {
    // Behat and dependencies are installed and we need to install the test site.
    chdir(__DIR__);
    passthru("php $utilfile --install $paralleloption", $code);
    if ($code != 0) {
        chdir($cwd);
        exit($code);
    }

} else if ($code == BEHAT_EXITCODE_REINSTALL) {
    // Test site data is outdated.
    chdir(__DIR__);
    passthru("php $utilfile --drop $paralleloption", $code);
    if ($code != 0) {
        chdir($cwd);
        exit($code);
    }

    chdir(__DIR__);
    passthru("php $utilfile --install $paralleloption", $code);
    if ($code != 0) {
        chdir($cwd);
        exit($code);
    }

} else if ($code == BEHAT_EXITCODE_COMPOSER) {
    // Missing Behat dependencies.
    // Returning to admin/tool/behat/cli.
    chdir(__DIR__);
    passthru("php $utilfile --install $paralleloption", $code);
    if ($code != 0) {
        chdir($cwd);
        exit($code);
    }

} else {
    // Generic error, we just output it.
    echo implode("\n", $output)."\n";
    chdir($cwd);
    exit($code);
}

// Enable editing mode according to config.php vars.
chdir(__DIR__);
passthru("php $utilfile --enable $paralleloption", $code);
if ($code != 0) {
    echo "Error enabling site" . PHP_EOL;
    chdir($cwd);
    exit($code);
}

exit(0);
