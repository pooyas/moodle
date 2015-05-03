<?php

/**
 * Capability overview settings
 *
 * @package    tool
 * @subpackage capability
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

$ADMIN->add('roles', new admin_externalpage(
    'toolcapability',
    get_string('pluginname', 'tool_capability'),
    "$CFG->wwwroot/$CFG->admin/tool/capability/index.php",
    'lion/role:manage'
));
