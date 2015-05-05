<?php

/**
 * @package    core
 * @subpackage files
 * @copyright  2015 Pooya Saeedi
 */


require_once('../config.php');
require_once(dirname(__FILE__) . '/coursefilesedit_form.php');
require_once($CFG->dirroot . '/repository/lib.php');

// current context
$contextid = required_param('contextid', PARAM_INT);
$component = 'course';
$filearea  = 'legacy';
$itemid    = 0;

list($context, $course, $cm) = get_context_info_array($contextid);

$url = new lion_url('/files/coursefilesedit.php', array('contextid'=>$contextid));

require_login($course);
require_capability('lion/course:managefiles', $context);

$PAGE->set_url($url);
$heading = get_string('coursefiles') . ': ' . format_string($course->fullname, true, array('context' => $context));
$strfiles = get_string("files");
if ($node = $PAGE->settingsnav->find('coursefiles', navigation_node::TYPE_SETTING)) {
    $node->make_active();
} else {
    $PAGE->navbar->add($strfiles);
}
$PAGE->set_context($context);
$PAGE->set_title($heading);
$PAGE->set_heading($heading);
$PAGE->set_pagelayout('incourse');

$data = new stdClass();
$options = array('subdirs'=>1, 'maxfiles'=>-1, 'accepted_types'=>'*', 'return_types'=>FILE_INTERNAL);
file_prepare_standard_filemanager($data, 'files', $options, $context, $component, $filearea, $itemid);
$form = new coursefiles_edit_form(null, array('data'=>$data, 'contextid'=>$contextid));

$returnurl = new lion_url('/files/index.php', array('contextid'=>$contextid));

if ($form->is_cancelled()) {
    redirect($returnurl);
}

if ($data = $form->get_data()) {
    $data = file_postupdate_standard_filemanager($data, 'files', $options, $context, $component, $filearea, $itemid);
    redirect($returnurl);
}

echo $OUTPUT->header();

echo $OUTPUT->container_start();
$form->display();
echo $OUTPUT->container_end();

echo $OUTPUT->footer();
