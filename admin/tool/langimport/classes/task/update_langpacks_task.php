<?php

/**
 * A scheduled task for updating langpacks.
 *
 * @package    tool_langimport
 * @copyright  2014 Dan Poltawski <dan@lion.com>
 * 
 */
namespace tool_langimport\task;

/**
 * A scheduled task for updating langpacks.
 *
 * @package    tool_langimport
 * @copyright  2014 Dan Poltawski <dan@lion.com>
 * 
 */
class update_langpacks_task extends \core\task\scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('updatelangs', 'tool_langimport');
    }

    /**
     * Run langpack update
     */
    public function execute() {
        global $CFG;

        if (!empty($CFG->skiplangupgrade)) {
            mtrace('Langpack update skipped. ($CFG->skiplangupgrade set)');

            return;
        }

        $controller = new \tool_langimport\controller();
        if ($controller->update_all_installed_languages()) {
            foreach ($controller->info as $message) {
                mtrace($message);
            }
            return true;
        } else {
            foreach ($controller->errors as $message) {
                mtrace($message);
            }
            return false;
        }

    }

}
