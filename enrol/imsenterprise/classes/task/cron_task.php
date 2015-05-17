<?php


/**
 * A scheduled task.
 *
 * @package    enrol
 * @subpackage imsenterprise
 * @copyright  2015 Pooya Saeedi
 */
namespace enrol_imsenterprise\task;

/**
 * Simple task to run the IMS Enterprise enrolment cron.
 *
 */
class cron_task extends \core\task\scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('imsenterprisecrontask', 'enrol_imsenterprise');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $CFG;
        require_once($CFG->dirroot . '/enrol/imsenterprise/lib.php');
        $ims = new \enrol_imsenterprise_plugin();
        $ims->cron();
    }

}
