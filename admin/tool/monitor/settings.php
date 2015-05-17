<?php


/**
 * Links and settings
 *
 * This file contains links and settings used by tool_monitor
 *
 * @package    admin_tool
 * @subpackage monitor
 * @copyright  2015 Pooya Saeedi
 */
defined('LION_INTERNAL') || die;

// Manage rules page.
$temp = new admin_externalpage(
    'toolmonitorrules',
    get_string('managerules', 'tool_monitor'),
    new lion_url('/admin/tool/monitor/managerules.php', array('courseid' => 0)),
    'tool/monitor:managerules'
);
$ADMIN->add('reports', $temp);
