<?php


/**
 * Adds this plugin to the admin menu.
 *
 * @package    admin_tool
 * @subpackage assignmentupgrade
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

if ($hassiteconfig) {
    // Needs this condition or there is error on login page.
    $ADMIN->add('root', new admin_externalpage('assignmentupgrade',
            get_string('pluginname', 'tool_assignmentupgrade'),
            new lion_url('/admin/tool/assignmentupgrade/index.php')));
}
