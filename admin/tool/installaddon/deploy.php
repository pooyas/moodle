<?php


/**
 * Deploy the validated contents of the ZIP package to the $CFG->dirroot
 *
 * @package     tool
 * @subpackage  installaddon
 * @copyright   2015 Pooya Saeedi
 * 
 */

require(dirname(__FILE__) . '/../../../config.php');
require_once($CFG->libdir.'/filelib.php');

require_login();
require_capability('lion/site:config', context_system::instance());

if (!empty($CFG->disableonclickaddoninstall)) {
    notice(get_string('featuredisabled', 'tool_installaddon'));
}

require_sesskey();

$jobid = required_param('jobid', PARAM_ALPHANUM);
$plugintype = required_param('type', PARAM_ALPHANUMEXT);
$pluginname = required_param('name', PARAM_PLUGIN);

$zipcontentpath = $CFG->tempdir.'/tool_installaddon/'.$jobid.'/contents';

if (!is_dir($zipcontentpath)) {
    debugging('Invalid location of the extracted ZIP package: '.s($zipcontentpath), DEBUG_DEVELOPER);
    redirect(new lion_url('/admin/tool/installaddon/index.php'),
        get_string('invaliddata', 'core_error'));
}

if (!is_dir($zipcontentpath.'/'.$pluginname)) {
    debugging('Invalid location of the plugin root directory: '.$zipcontentpath.'/'.$pluginname, DEBUG_DEVELOPER);
    redirect(new lion_url('/admin/tool/installaddon/index.php'),
        get_string('invaliddata', 'core_error'));
}

$installer = tool_installaddon_installer::instance();

if (!$installer->is_plugintype_writable($plugintype)) {
    debugging('Plugin type location not writable', DEBUG_DEVELOPER);
    redirect(new lion_url('/admin/tool/installaddon/index.php'),
        get_string('invaliddata', 'core_error'));
}

$plugintypepath = $installer->get_plugintype_root($plugintype);

if (file_exists($plugintypepath.'/'.$pluginname)) {
    debugging('Target location already exists', DEBUG_DEVELOPER);
    redirect(new lion_url('/admin/tool/installaddon/index.php'),
        get_string('invaliddata', 'core_error'));
}

// Copy permissions form the plugin type directory.
$dirpermissions = fileperms($plugintypepath);
$filepermissions = ($dirpermissions & 0666); // Strip execute flags.

$installer->move_directory($zipcontentpath.'/'.$pluginname, $plugintypepath.'/'.$pluginname, $dirpermissions, $filepermissions);
fulldelete($CFG->tempdir.'/tool_installaddon/'.$jobid);
redirect(new lion_url('/admin'));
