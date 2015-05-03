<?php

/**
 * All in one init script - PHP version.
 *
 * @package    tool
 * @subpackage phpunit
 * @copyright  2015 Pooya Saeedi 
 * 
 */

if (isset($_SERVER['REMOTE_ADDR'])) {
    die; // no access from web!
}

// Force OPcache reset if used, we do not want any stale caches
// when preparing test environment.
if (function_exists('opcache_reset')) {
    opcache_reset();
}

define('IGNORE_COMPONENT_CACHE', true);

require_once(__DIR__.'/../../../../lib/clilib.php');
require_once(__DIR__.'/../../../../lib/phpunit/bootstraplib.php');
require_once(__DIR__.'/../../../../lib/testing/lib.php');

echo "Initialising Lion PHPUnit test environment...\n";

$output = null;
exec('php --version', $output, $code);
if ($code != 0) {
    phpunit_bootstrap_error(1, 'Can not execute \'php\' binary.');
}

chdir(__DIR__);
$output = null;
exec("php util.php --diag", $output, $code);
if ($code == 0) {
    // everything is ready

} else if ($code == PHPUNIT_EXITCODE_INSTALL) {
    passthru("php util.php --install", $code);
    if ($code != 0) {
        exit($code);
    }

} else if ($code == PHPUNIT_EXITCODE_REINSTALL) {
    passthru("php util.php --drop", $code);
    passthru("php util.php --install", $code);
    if ($code != 0) {
        exit($code);
    }

} else {
    echo implode("\n", $output)."\n";
    exit($code);
}

passthru("php util.php --buildconfig", $code);

exit(0);
