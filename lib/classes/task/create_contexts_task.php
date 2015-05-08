<?php

/**
 * Scheduled task class.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */
namespace core\task;

/**
 * Simple task to create missing contexts at all levels.
 */
class create_contexts_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskcreatecontexts', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        // Make sure all context instances are properly created - they may be required in auth, enrol, etc.
        \context_helper::create_instances();
        mtrace(' Created missing context instances');
    }

}
