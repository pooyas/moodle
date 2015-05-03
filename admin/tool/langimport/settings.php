<?php

/**
 * Lang import
 *
 * @package    tool
 * @subpackage langimport
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('language', new admin_externalpage('toollangimport', get_string('pluginname', 'tool_langimport'), "$CFG->wwwroot/$CFG->admin/tool/langimport/index.php"));
}

