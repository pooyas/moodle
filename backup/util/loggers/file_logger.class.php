<?php

/**
 * @package     core
 * @subpackage backup
 * @copyright   2015 Pooya Saeedi
 */

/**
 * Logger implementation that sends indented messages (depth option) to one file
 *
 * TODO: Finish phpdocs
 */
class file_logger extends base_logger {

    protected $fullpath; // Full path to OS file where contents will be stored
    protected $fhandle;  // File handle where all write operations happen

    public function __construct($level, $showdate = false, $showlevel = false, $fullpath = null) {
        if (empty($fullpath)) {
            throw new base_logger_exception('missing_fullpath_parameter', $fullpath);
        }
        if (!is_writable(dirname($fullpath))) {
            throw new base_logger_exception('file_not_writable', $fullpath);
        }
        // Open the OS file for writing (append)
        $this->fullpath = $fullpath;
        if ($level > backup::LOG_NONE) { // Only create the file if we are going to log something
            if (! $this->fhandle = fopen($this->fullpath, 'a')) {
                throw new base_logger_exception('error_opening_file', $fullpath);
            }
        }
        parent::__construct($level, $showdate, $showlevel);
    }

    public function __destruct() {
        @fclose($this->fhandle); // Blindy close the file handler (no exceptions in destruct)
    }

    public function __sleep() {
        @fclose($this->fhandle); // Blindy close the file handler before serialization
        return array('level', 'showdate', 'showlevel', 'next', 'fullpath');
    }

    public function __wakeup() {
        if ($this->level > backup::LOG_NONE) { // Only create the file if we are going to log something
            if (! $this->fhandle = fopen($this->fullpath, 'a')) {
                throw new base_logger_exception('error_opening_file', $this->fullpath);
            }
        }
    }

// Protected API starts here

    protected function action($message, $level, $options = null) {
        $prefix = $this->get_prefix($level, $options);
        $depth = isset($options['depth']) ? $options['depth'] : 0;
        // Depending of the type (extension of the file), format differently
        if (substr($this->fullpath, -5) !== '.html') {
            $content = $prefix . str_repeat('  ', $depth) . $message . PHP_EOL;
        } else {
            $content = $prefix . str_repeat('&nbsp;&nbsp;', $depth) . htmlentities($message, ENT_QUOTES, 'UTF-8') . '<br/>' . PHP_EOL;
        }
        if (false === fwrite($this->fhandle, $content)) {
            throw new base_logger_exception('error_writing_file', $this->fullpath);
        }
        return true;
    }
}
