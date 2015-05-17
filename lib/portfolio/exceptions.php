<?php


/**
 * This file contains all the portfolio exception classes.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Top level portfolio exception.
 *
 * Sometimes caught and re-thrown as portfolio_export_exception
 * @see portfolio_export_exception
 *
 * @category portfolio
 */
class portfolio_exception extends lion_exception {}

/**
 * Exception to throw during an export - will clean up session and tempdata
 *
 * @category portfolio
 */
class portfolio_export_exception extends portfolio_exception {

    /**
     * Constructor.
     *
     * @param portfolio_exporter $exporter instance of portfolio_exporter (will handle null case)
     * @param string $errorcode language string key
     * @param string $module language string module (optional, defaults to lion)
     * @param string $continue url to continue to (optional, defaults to wwwroot)
     * @param object $a language string data (optional, defaults to  null)
     */
    public function __construct($exporter, $errorcode, $module=null, $continue=null, $a=null) {
        global $CFG;
        // This static variable is necessary because sometimes the code below
        // which tries to obtain a continue link can cause one of these
        // exceptions to be thrown. This would create an infinite loop (until
        // PHP hits its stack limit). Using this static lets us make the
        // nested constructor finish immediately without attempting to call
        // methods that might fail.
        static $inconstructor = false;

        if (!$inconstructor && !empty($exporter) &&
                $exporter instanceof portfolio_exporter) {
            $inconstructor = true;
            try {
                if (empty($continue)) {
                    $caller = $exporter->get('caller');
                    if (!empty($caller) && $caller instanceof portfolio_caller_base) {
                        $continue = $exporter->get('caller')->get_return_url();
                    }
                }
                // this was previously only called if we were in cron,
                // but I think if there's always an exception, we should clean up
                // rather than force the user to resolve the export later.
                $exporter->process_stage_cleanup();
            } catch(Exception $e) {
                // Ooops, we had an exception trying to get caller
                // information. Ignore it.
            }
            $inconstructor = false;
        }
        parent::__construct($errorcode, $module, $continue, $a);
    }
}

/**
 * Exception for callers to throw when they have a problem.
 *
 * Usually caught and rethrown as portfolio_export_exception
 * @see portfolio_export_exception
 *
 * @category portfolio
 */
class portfolio_caller_exception extends portfolio_exception {}

/**
 * Exception for portfolio plugins to throw when they have a problem.
 *
 * Usually caught and rethrown as portfolio_export_exception
 * @see portfolio_export_exception
 *
 * @category portfolio
 */
class portfolio_plugin_exception extends portfolio_exception {}

/**
 * Exception for interacting with the button class
 *
 * @category portfolio
 */
class portfolio_button_exception extends portfolio_exception {}

/**
 * Leap2a exception - for invalid api calls
 *
 * @category portfolio
 */
class portfolio_format_leap2a_exception extends portfolio_exception {}
