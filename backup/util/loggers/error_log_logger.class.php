<?php


/**
 * @package    core
 * @subpackage backup-logger
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Logger implementation that sends messages to error_log()
 *
 * TODO: Finish phpdocs
 */
class error_log_logger extends base_logger {

// Protected API starts here

    protected function action($message, $level, $options = null) {
        if (PHPUNIT_TEST) {
            // no logging from PHPUnit, it is admins fault if it does not work!!!
            return true;
        }
        return error_log($message);
    }
}
