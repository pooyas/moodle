<?php

/**
 * Capability overview settings
 *
 * @package    tool_capability
 * @copyright  2008 Tim Hunt
 * 
 */

defined('LION_INTERNAL') || die;

$ADMIN->add('roles', new admin_externalpage(
    'toolcapability',
    get_string('pluginname', 'tool_capability'),
    "$CFG->wwwroot/$CFG->admin/tool/capability/index.php",
    'lion/role:manage'
));
