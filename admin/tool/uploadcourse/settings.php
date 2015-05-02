<?php

/**
 * Link to CSV course upload.
 *
 * @package    tool_uploadcourse
 * @copyright  2011 Piers Harding
 * 
 */

defined('LION_INTERNAL') || die();

if ($hassiteconfig) {
    $ADMIN->add('courses', new admin_externalpage('tooluploadcourse',
        get_string('uploadcourses', 'tool_uploadcourse'), "$CFG->wwwroot/$CFG->admin/tool/uploadcourse/index.php"));
}
