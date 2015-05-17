<?php


/**
 * PHPUnit bootstrap function
 *
 * Note: these functions must be self contained and must not rely on any other library or include
 *
 * @category   phpunit
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

require_once(__DIR__ . '/../testing/lib.php');

define('PHPUNIT_EXITCODE_PHPUNITMISSING', 129);
define('PHPUNIT_EXITCODE_PHPUNITWRONG', 130);
define('PHPUNIT_EXITCODE_PHPUNITEXTMISSING', 131);
define('PHPUNIT_EXITCODE_CONFIGERROR', 135);
define('PHPUNIT_EXITCODE_CONFIGWARNING', 136);
define('PHPUNIT_EXITCODE_INSTALL', 140);
define('PHPUNIT_EXITCODE_REINSTALL', 141);

/**
 * Print error and stop execution
 * @param int $errorcode The exit error code
 * @param string $text An error message to display
 * @return void stops code execution with error code
 */
function phpunit_bootstrap_error($errorcode, $text = '') {
    switch ($errorcode) {
        case 0:
            // this is not an error, just print information and exit
            break;
        case 1:
            $text = 'Error: '.$text;
            break;
        case PHPUNIT_EXITCODE_PHPUNITMISSING:
            $text = "Can not find PHPUnit library, to install use: php composer.phar install --dev";
            break;
        case PHPUNIT_EXITCODE_PHPUNITWRONG:
            $text = 'Lion requires PHPUnit 3.6.x, '.$text.' is not compatible';
            break;
        case PHPUNIT_EXITCODE_PHPUNITEXTMISSING:
            $text = 'Lion can not find required PHPUnit extension '.$text;
            break;
        case PHPUNIT_EXITCODE_CONFIGERROR:
            $text = "Lion PHPUnit environment configuration error:\n".$text;
            break;
        case PHPUNIT_EXITCODE_CONFIGWARNING:
            $text = "Lion PHPUnit environment configuration warning:\n".$text;
            break;
        case PHPUNIT_EXITCODE_INSTALL:
            $path = testing_cli_argument_path('/admin/tool/phpunit/cli/init.php');
            $text = "Lion PHPUnit environment is not initialised, please use:\n php $path";
            break;
        case PHPUNIT_EXITCODE_REINSTALL:
            $path = testing_cli_argument_path('/admin/tool/phpunit/cli/init.php');
            $text = "Lion PHPUnit environment was initialised for different version, please use:\n php $path";
            break;
        default:
            $text = empty($text) ? '' : ': '.$text;
            $text = 'Unknown error '.$errorcode.$text;
            break;
    }

    testing_error($errorcode, $text);
}
