<?php


/**
 * @package    core
 * @subpackage backup-logger
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Logger implementation that sends indented messages (depth option) to output
 *
 * TODO: Finish phpdocs
 */
class output_indented_logger extends base_logger {

// Protected API starts here

    protected function action($message, $level, $options = null) {
        $prefix = $this->get_prefix($level, $options);
        $depth = isset($options['depth']) ? $options['depth'] : 0;
        // Depending of running from browser/command line, format differently
        if (defined('STDOUT')) {
            echo $prefix . str_repeat('  ', $depth) . $message . PHP_EOL;
        } else {
            echo $prefix . str_repeat('&nbsp;&nbsp;', $depth) . htmlentities($message, ENT_QUOTES, 'UTF-8') . '<br/>' . PHP_EOL;
        }
        flush();
        return true;
    }
}
