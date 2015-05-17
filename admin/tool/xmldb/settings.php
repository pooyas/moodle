<?php


/**
 * Link to xmldb editor
 *
 * @package    admin_tool
 * @subpackage xmldb
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('development', new admin_externalpage('toolxmld', get_string('pluginname', 'tool_xmldb'), "$CFG->wwwroot/$CFG->admin/tool/xmldb/"));
}
