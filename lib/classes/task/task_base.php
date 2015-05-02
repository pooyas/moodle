<?php

/**
 * Abstract class for common properties of scheduled_task and adhoc_task.
 *
 * @package    core
 * @category   task
 * @copyright  2013 Damyon Wiese
 * 
 */
namespace core\task;

/**
 * Abstract class for common properties of scheduled_task and adhoc_task.
 *
 * @copyright  2013 Damyon Wiese
 * 
 */
abstract class task_base {

    /** @var \core\lock\lock $lock - The lock controlling this task. */
    private $lock = null;

    /** @var \core\lock\lock $cronlock - The lock controlling the entire cron process. */
    private $cronlock = null;

    /** @var $string $component - The component this task belongs to. */
    private $component = '';

    /** @var bool $blocking - Does this task block the entire cron process. */
    private $blocking = false;

    /** @var int $faildelay - Exponentially increasing fail delay */
    private $faildelay = 0;

    /** @var int $nextruntime - When this task is due to run next */
    private $nextruntime = 0;

    /**
     * Set the current lock for this task.
     * @param \core\lock\lock $lock
     */
    public function set_lock(\core\lock\lock $lock) {
        $this->lock = $lock;
    }

    /**
     * Set the current lock for the entire cron process.
     * @param \core\lock\lock $lock
     */
    public function set_cron_lock(\core\lock\lock $lock) {
        $this->cronlock = $lock;
    }

    /**
     * Get the current lock for this task.
     * @return \core\lock\lock
     */
    public function get_lock() {
        return $this->lock;
    }

    /**
     * Get the next run time for this task.
     * @return int timestamp
     */
    public function get_next_run_time() {
        return $this->nextruntime;
    }

    /**
     * Set the next run time for this task.
     * @param int $nextruntime
     */
    public function set_next_run_time($nextruntime) {
        $this->nextruntime = $nextruntime;
    }

    /**
     * Get the current lock for the entire cron.
     * @return \core\lock\lock
     */
    public function get_cron_lock() {
        return $this->cronlock;
    }

    /**
     * Setter for $blocking.
     * @param bool $blocking
     */
    public function set_blocking($blocking) {
        $this->blocking = $blocking;
    }

    /**
     * Getter for $blocking.
     * @return bool
     */
    public function is_blocking() {
        return $this->blocking;
    }

    /**
     * Setter for $component.
     * @param string $component
     */
    public function set_component($component) {
        $this->component = $component;
    }

    /**
     * Getter for $component.
     * @return string
     */
    public function get_component() {
        return $this->component;
    }

    /**
     * Setter for $faildelay.
     * @param int $faildelay
     */
    public function set_fail_delay($faildelay) {
        $this->faildelay = $faildelay;
    }

    /**
     * Getter for $faildelay.
     * @return int
     */
    public function get_fail_delay() {
        return $this->faildelay;
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public abstract function execute();
}
