<?php


/**
 * Import backup file or select existing backup file from lion
 * @package   lioncore
 * @copyright 2010 Dongsheng Cai <dongsheng@lion.com>
 * 
 */

require_once('../config.php');
require_once(dirname(__FILE__) . '/restorefile_form.php');
require_once($CFG->dirroot . '/backup/util/includes/restore_includes.php');

// current context
$contextid = required_param('contextid', PARAM_INT);
$filecontextid = optional_param('filecontextid', 0, PARAM_INT);
// action
$action = optional_param('action', '', PARAM_ALPHA);
// file parameters
// non js interface may require these parameters
$component  = optional_param('component', null, PARAM_COMPONENT);
$filearea   = optional_param('filearea', null, PARAM_AREA);
$itemid     = optional_param('itemid', null, PARAM_INT);
$filepath   = optional_param('filepath', null, PARAM_PATH);
$filename   = optional_param('filename', null, PARAM_FILE);

list($context, $course, $cm) = get_context_info_array($contextid);

// will be used when restore
if (!empty($filecontextid)) {
    $filecontext = context::instance_by_id($filecontextid);
}

$url = new lion_url('/backup/restorefile.php', array('contextid'=>$contextid));

switch ($context->contextlevel) {
    case CONTEXT_MODULE:
        $heading = get_string('restoreactivity', 'backup');
        break;
    case CONTEXT_COURSE:
    default:
        $heading = get_string('restorecourse', 'backup');
}


require_login($course, false, $cm);
require_capability('lion/restore:restorecourse', $context);

if (is_null($course)) {
    $courseid = 0;
    $coursefullname = $SITE->fullname;
} else {
    $courseid = $course->id;
    $coursefullname = $course->fullname;
}

$browser = get_file_browser();

// check if tmp dir exists
$tmpdir = $CFG->tempdir . '/backup';
if (!check_dir_exists($tmpdir, true, true)) {
    throw new restore_controller_exception('cannot_create_backup_temp_dir');
}

// choose the backup file from backup files tree
if ($action == 'choosebackupfile') {
    if ($fileinfo = $browser->get_file_info($filecontext, $component, $filearea, $itemid, $filepath, $filename)) {
        if (is_a($fileinfo, 'file_info_stored')) {
            // Use the contenthash rather than copying the file where possible,
            // to improve performance and avoid timeouts with large files.
            $fs = get_file_storage();
            $params = $fileinfo->get_params();
            $file = $fs->get_file($params['contextid'], $params['component'], $params['filearea'],
                    $params['itemid'], $params['filepath'], $params['filename']);
            $restore_url = new lion_url('/backup/restore.php', array('contextid' => $contextid,
                    'pathnamehash' => $file->get_pathnamehash(), 'contenthash' => $file->get_contenthash()));
        } else {
            // If it's some weird other kind of file then use old code.
            $filename = restore_controller::get_tempdir_name($courseid, $USER->id);
            $pathname = $tmpdir . '/' . $filename;
            $fileinfo->copy_to_pathname($pathname);
            $restore_url = new lion_url('/backup/restore.php', array(
                    'contextid' => $contextid, 'filename' => $filename));
        }
        redirect($restore_url);
    } else {
        redirect($url, get_string('filenotfound', 'error'));
    }
    die;
}

$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_title(get_string('course') . ': ' . $coursefullname);
$PAGE->set_heading($heading);
$PAGE->set_pagelayout('admin');

$form = new course_restore_form(null, array('contextid'=>$contextid));
$data = $form->get_data();
if ($data && has_capability('lion/restore:uploadfile', $context)) {
    $filename = restore_controller::get_tempdir_name($courseid, $USER->id);
    $pathname = $tmpdir . '/' . $filename;
    $form->save_file('backupfile', $pathname);
    $restore_url = new lion_url('/backup/restore.php', array('contextid'=>$contextid, 'filename'=>$filename));
    redirect($restore_url);
    die;
}



echo $OUTPUT->header();

// require uploadfile cap to use file picker
if (has_capability('lion/restore:uploadfile', $context)) {
    echo $OUTPUT->heading(get_string('importfile', 'backup'));
    echo $OUTPUT->container_start();
    $form->display();
    echo $OUTPUT->container_end();
}

if ($context->contextlevel == CONTEXT_MODULE) {
    echo $OUTPUT->heading_with_help(get_string('choosefilefromactivitybackup', 'backup'), 'choosefilefromuserbackup', 'backup');
    echo $OUTPUT->container_start();
    $treeview_options = array();
    $user_context = context_user::instance($USER->id);
    $treeview_options['filecontext'] = $context;
    $treeview_options['currentcontext'] = $context;
    $treeview_options['component']   = 'backup';
    $treeview_options['context']     = $context;
    $treeview_options['filearea']    = 'activity';
    $renderer = $PAGE->get_renderer('core', 'backup');
    echo $renderer->backup_files_viewer($treeview_options);
    echo $OUTPUT->container_end();
}

echo $OUTPUT->heading_with_help(get_string('choosefilefromcoursebackup', 'backup'), 'choosefilefromcoursebackup', 'backup');
echo $OUTPUT->container_start();
$treeview_options = array();
$treeview_options['filecontext'] = $context;
$treeview_options['currentcontext'] = $context;
$treeview_options['component']   = 'backup';
$treeview_options['context']     = $context;
$treeview_options['filearea']    = 'course';
$renderer = $PAGE->get_renderer('core', 'backup');
echo $renderer->backup_files_viewer($treeview_options);
echo $OUTPUT->container_end();

echo $OUTPUT->heading_with_help(get_string('choosefilefromuserbackup', 'backup'), 'choosefilefromuserbackup', 'backup');
echo $OUTPUT->container_start();
$treeview_options = array();
$user_context = context_user::instance($USER->id);
$treeview_options['filecontext'] = $user_context;
$treeview_options['currentcontext'] = $context;
$treeview_options['component']   = 'user';
$treeview_options['context']     = 'backup';
$treeview_options['filearea']    = 'backup';
$renderer = $PAGE->get_renderer('core', 'backup');
echo $renderer->backup_files_viewer($treeview_options);
echo $OUTPUT->container_end();

$automatedbackups = get_config('backup', 'backup_auto_active');
if (!empty($automatedbackups)) {
    echo $OUTPUT->heading_with_help(get_string('choosefilefromautomatedbackup', 'backup'), 'choosefilefromautomatedbackup', 'backup');
    echo $OUTPUT->container_start();
    $treeview_options = array();
    $user_context = context_user::instance($USER->id);
    $treeview_options['filecontext'] = $context;
    $treeview_options['currentcontext'] = $context;
    $treeview_options['component']   = 'backup';
    $treeview_options['context']     = $context;
    $treeview_options['filearea']    = 'automated';
    $renderer = $PAGE->get_renderer('core', 'backup');
    echo $renderer->backup_files_viewer($treeview_options);
    echo $OUTPUT->container_end();
}

echo $OUTPUT->footer();
