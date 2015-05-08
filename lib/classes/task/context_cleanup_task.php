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
 * Simple task to delete old context records.
 */
class context_cleanup_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskcontextcleanup', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        // Context maintenance stuff.
        \context_helper::cleanup_instances();
        mtrace(' Cleaned up context instances');
        \context_helper::build_all_paths(false);
        // If you suspect that the context paths are somehow corrupt
        // replace the line below with: context_helper::build_all_paths(true).
    }

}
