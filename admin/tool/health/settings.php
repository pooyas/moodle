<?php

/**
 * Capability overview settings
 *
 * @package    tool
 * @subpackage health
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('unsupported', new admin_externalpage('toolhealth', get_string('pluginname', 'tool_health'), $CFG->wwwroot.'/'.$CFG->admin.'/tool/health/index.php', 'lion/site:config', true));
}
