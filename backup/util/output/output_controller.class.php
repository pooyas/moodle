<?php

/**
 * @package     core
 * @subpackage backup
 * @copyright   2015 Pooya Saeedi
 *
 * TODO: Finish phpdocs
 */

/**
 * This class decides, based in environment/backup controller settings about
 * the best way to send information to output, independently of the process
 * and the loggers. Instantiated/configured by @backup_controller constructor
 *
 * Mainly used by backup_helper::log() (that receives all the log requests from
 * the rest of backup objects) to split messages both to loggers and to output.
 *
 * This class adopts the singleton pattern to be able to provide some persistency
 * and global access.
 */
class output_controller {

    private static $instance; // The unique instance of output_controller available along the request
    private $list;            // progress_trace object we are going to use for output
    private $active;          // To be able to stop output completely or active it again

    private function __construct() { // Private constructor
        if (defined('STDOUT')) { // text mode
            $this->list = new text_progress_trace();
        } else {
            $this->list = new html_list_progress_trace();
        }
        $this->active = false; // Somebody has to active me before outputing anything
    }

    public static function get_instance() {
        if (!isset(self::$instance)) {
            self::$instance = new output_controller();
        }
        return self::$instance;
    }

    public function set_active($active) {
        if ($this->active && (bool)$active == false) { // Stopping, call finished()
            $this->list->finished();
        }
        $this->active = (bool)$active;
    }

    public function output($message, $langfile, $a, $depth) {
        if ($this->active) {
            $stringkey = preg_replace('/\s/', '', $message); // String key is message without whitespace
            $message = get_string($stringkey, $langfile, $a);
            $this->list->output($message, $depth);
        }
    }
}
