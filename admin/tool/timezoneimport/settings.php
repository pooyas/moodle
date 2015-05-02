<?php

/**
 * Plugin version info
 *
 * @package    tool
 * @subpackage timezoneimport
 * @copyright  2011 Petr Skoda {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('location', new admin_externalpage('tooltimezoneimport', get_string('updatetimezones', 'tool_timezoneimport'), "$CFG->wwwroot/$CFG->admin/tool/timezoneimport/index.php"));
}

