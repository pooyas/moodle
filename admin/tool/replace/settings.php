<?php

/**
 * Link to unsupported db replace script.
 *
 * @package    tool
 * @subpackage replace
 * @copyright  2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('unsupported', new admin_externalpage('toolreplace', get_string('pluginname', 'tool_replace'), $CFG->wwwroot.'/'.$CFG->admin.'/tool/replace/index.php', 'lion/site:config', true));
}
