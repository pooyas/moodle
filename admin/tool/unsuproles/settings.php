<?php


/**
 * Link to unsupported roles tool
 *
 * @package    admin_tool
 * @subpackage unsuproles
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('roles', new admin_externalpage('toolunsuproles', get_string('pluginname', 'tool_unsuproles'), "$CFG->wwwroot/$CFG->admin/tool/unsuproles/index.php", array('lion/site:config', 'lion/role:assign')));
}
