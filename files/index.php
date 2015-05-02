<?php


/**
 * Lion file tree viewer based on YUI2 Treeview
 *
 * @package    core
 * @subpackage file
 * @copyright  2010 Dongsheng Cai <dongsheng@lion.com>
 * 
 */

require('../config.php');

$contextid  = optional_param('contextid', 0, PARAM_INT);
$filepath   = optional_param('filepath', '', PARAM_PATH);
$filename   = optional_param('filename', '', PARAM_FILE);
// hard-coded to course legacy area
$component = 'course';
$filearea  = 'legacy';
$itemid    = 0;

if (empty($contextid)) {
    $contextid = context_course::instance(SITEID)->id;
}

$PAGE->set_url('/files/index.php', array('contextid'=>$contextid, 'filepath'=>$filepath, 'filename'=>$filename));
navigation_node::override_active_url(new lion_url('/files/index.php', array('contextid'=>$contextid)));

if ($filepath === '') {
    $filepath = null;
}

if ($filename === '') {
    $filename = null;
}

list($context, $course, $cm) = get_context_info_array($contextid);
$PAGE->set_context($context);

require_login($course, false, $cm);
require_capability('lion/course:managefiles', $context);

$browser = get_file_browser();

$file_info = $browser->get_file_info($context, $component, $filearea, $itemid, $filepath, $filename);

$strfiles = get_string("files");
if ($node = $PAGE->settingsnav->find('coursefiles', navigation_node::TYPE_SETTING)) {
    $node->make_active();
} else {
    $PAGE->navbar->add($strfiles);
}

$PAGE->set_title("$course->shortname: $strfiles");
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('incourse');

$output = $PAGE->get_renderer('core', 'files');

echo $output->header();
echo $output->box_start();

if ($file_info) {
    $options = array();
    $options['context'] = $context;
    //$options['visible_areas'] = array('backup'=>array('section', 'course'), 'course'=>array('legacy'), 'user'=>array('backup'));
    echo $output->files_tree_viewer($file_info, $options);
} else {
    echo $output->notification(get_string('nofilesavailable', 'repository'));
}

echo $output->box_end();
echo $output->footer();
