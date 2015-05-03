<?php

/**
 * Profiling tool settings.
 *
 * @package    tool
 * @subpackage profiling
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

// profiling tool, added to development
if (extension_loaded('xhprof') && function_exists('xhprof_enable') && (!empty($CFG->profilingenabled) || !empty($CFG->earlyprofilingenabled))) {
    $ADMIN->add('development', new admin_externalpage('toolprofiling', get_string('pluginname', 'tool_profiling'), "$CFG->wwwroot/$CFG->admin/tool/profiling/index.php", 'lion/site:config'));
}
