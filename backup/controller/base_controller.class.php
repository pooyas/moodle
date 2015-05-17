<?php


/**
 * Base class with shared stuff between backup controller and restore
 * controller.
 *
 * @package    backup
 * @subpackage controller
 * @copyright  2015 Pooya Saeedi
 */
abstract class base_controller extends backup implements loggable {
    /**
     * @var \core\progress\base Progress reporting object.
     */
    protected $progress;

    /**
     * @var base_logger Logging chain object (lion, inline, fs, db, syslog)
     */
    protected $logger;

    /**
     * Gets the progress reporter, which can be used to report progress within
     * the backup or restore process.
     *
     * @return \core\progress\base Progress reporting object
     */
    public function get_progress() {
        return $this->progress;
    }

    /**
     * Sets the progress reporter.
     *
     * @param \core\progress\base $progress Progress reporting object
     */
    public function set_progress(\core\progress\base $progress) {
        $this->progress = $progress;
    }

    /**
     * Gets first logger in logging chain.
     *
     * @return base_logger Logger
     */
    public function get_logger() {
        return $this->logger;
    }

    /**
     * Inserts a new logger at end of logging chain.
     *
     * @param base_logger $logger New logger to add
     */
    public function add_logger(base_logger $logger) {
        $existing = $this->logger;
        while ($existing->get_next()) {
            $existing = $existing->get_next();
        }
        $existing->set_next($logger);
    }

    /**
     * Logs data to the logger chain.
     *
     * @see loggable::log()
     */
    public function log($message, $level, $a = null, $depth = null, $display = false) {
        backup_helper::log($message, $level, $a, $depth, $display, $this->logger);
    }
}
