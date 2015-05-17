<?php


/**
 * Configure the setting page of the custom file type as an external page.
 *
 * @package    admin_tool
 * @subpackage filetypes
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('server', new admin_externalpage('tool_filetypes',
            new lang_string('pluginname', 'tool_filetypes'),
            $CFG->wwwroot . '/admin/tool/filetypes/index.php'));
}
