<?php

/**
 * Configure the setting page of the custom file type as an external page.
 *
 * @package tool_filetypes
 * @copyright 2014 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('LION_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('server', new admin_externalpage('tool_filetypes',
            new lang_string('pluginname', 'tool_filetypes'),
            $CFG->wwwroot . '/admin/tool/filetypes/index.php'));
}
