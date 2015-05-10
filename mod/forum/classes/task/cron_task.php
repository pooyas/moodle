<?php

/**
 * A scheduled task for forum cron.
 *
 * @todo MDL-44734 This job will be split up properly.
 *
 * @package    mod
 * @subpackage forum
 * @copyright  2015 Pooya Saeedi
 * 
 */
namespace mod_forum\task;

class cron_task extends \core\task\scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('crontask', 'mod_forum');
    }

    /**
     * Run forum cron.
     */
    public function execute() {
        global $CFG;
        require_once($CFG->dirroot . '/mod/forum/lib.php');
        forum_cron();
    }

}
