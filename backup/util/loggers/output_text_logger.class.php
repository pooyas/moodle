<?php


/**
 * @package    lioncore
 * @subpackage backup-logger
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Logger implementation that sends text messages to output
 *
 * TODO: Finish phpdocs
 */
class output_text_logger extends base_logger {

// Protected API starts here

    protected function action($message, $level, $options = null) {
        $prefix = $this->get_prefix($level, $options);
        // Depending of running from browser/command line, format differently
        if (defined('STDOUT')) {
            echo $prefix . $message . PHP_EOL;
        } else {
            echo $prefix . htmlentities($message, ENT_QUOTES, 'UTF-8') . '<br/>' . PHP_EOL;
        }
        flush();
        return true;
    }
}
