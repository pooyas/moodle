<?php

/**
 * A scheduled task.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */
namespace core\task;

/**
 * Simple task to delete old cache records.
 */
class cache_cleanup_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskcachecleanup', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        // Remove expired cache flags.
        gc_cache_flags();

    }

}
