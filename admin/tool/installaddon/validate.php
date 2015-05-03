<?php


/**
 * The ZIP package validation.
 *
 * @package     tool
 * @subpackage  installaddon
 * @copyright   2015 Pooya Saeedi
 * 
 */

require(dirname(__FILE__) . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/filelib.php');

navigation_node::override_active_url(new lion_url('/admin/tool/installaddon/index.php'));
admin_externalpage_setup('tool_installaddon_validate');

if (!empty($CFG->disableonclickaddoninstall)) {
    notice(get_string('featuredisabled', 'tool_installaddon'));
}

require_sesskey();

$jobid = required_param('jobid', PARAM_ALPHANUM);
$zipfilename = required_param('zip', PARAM_FILE);
$plugintype = required_param('type', PARAM_ALPHANUMEXT);
$rootdir = optional_param('rootdir', '', PARAM_PLUGIN);

$zipfilepath = $CFG->tempdir.'/tool_installaddon/'.$jobid.'/source/'.$zipfilename;
if (!file_exists($zipfilepath)) {
    redirect(new lion_url('/admin/tool/installaddon/index.php'),
        get_string('invaliddata', 'core_error'));
}

$installer = tool_installaddon_installer::instance();

// Extract the ZIP contents.
fulldelete($CFG->tempdir.'/tool_installaddon/'.$jobid.'/contents');
$zipcontentpath = make_temp_directory('tool_installaddon/'.$jobid.'/contents');
$zipcontentfiles = $installer->extract_installfromzip_file($zipfilepath, $zipcontentpath, $rootdir);

// Validate the contents of the plugin ZIP file.
$validator = tool_installaddon_validator::instance($zipcontentpath, $zipcontentfiles);
$validator->assert_plugin_type($plugintype);
$validator->assert_lion_version($CFG->version);
$result = $validator->execute();

if ($result) {
    $validator->set_continue_url(new lion_url('/admin/tool/installaddon/deploy.php', array(
        'sesskey' => sesskey(),
        'jobid' => $jobid,
        'type' => $plugintype,
        'name' => $validator->get_rootdir())));

} else {
    fulldelete($CFG->tempdir.'/tool_installaddon/'.$jobid);
}

// Display the validation results.
$output = $PAGE->get_renderer('tool_installaddon');
$output->set_installer_instance($installer);
$output->set_validator_instance($validator);
echo $output->validation_page();
