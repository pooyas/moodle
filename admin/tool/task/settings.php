<?php

/**
 * Scheduled tasks.
 *
 * @package    tool_task
 * @copyright  2014 Damyon Wiese
 * 
 */

defined('LION_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('server', new admin_externalpage('scheduledtasks', new lang_string('scheduledtasks','tool_task'), "$CFG->wwwroot/$CFG->admin/tool/task/scheduledtasks.php"));
}
