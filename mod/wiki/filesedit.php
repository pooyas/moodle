<?php


/**
 * Manage files in wiki
 *
 * @package    mod
 * @subpackage wiki
 * @copyright  2015 Pooya Saeedi
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once('lib.php');
require_once('locallib.php');
require_once("$CFG->dirroot/mod/wiki/filesedit_form.php");
require_once("$CFG->dirroot/repository/lib.php");

$subwikiid = required_param('subwiki', PARAM_INT);
// not being used for file management, we use it to generate navbar link
$pageid    = optional_param('pageid', 0, PARAM_INT);
$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);

if (!$subwiki = wiki_get_subwiki($subwikiid)) {
    print_error('incorrectsubwikiid', 'wiki');
}

// Checking wiki instance of that subwiki
if (!$wiki = wiki_get_wiki($subwiki->wikiid)) {
    print_error('incorrectwikiid', 'wiki');
}

// Checking course module instance
if (!$cm = get_coursemodule_from_instance("wiki", $subwiki->wikiid)) {
    print_error('invalidcoursemodule');
}

// Checking course instance
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);

$context = context_module::instance($cm->id);

require_login($course, true, $cm);

if (!wiki_user_can_view($subwiki, $wiki)) {
    print_error('cannotviewpage', 'wiki');
}
require_capability('mod/wiki:managefiles', $context);

if (empty($returnurl)) {
    if (!empty($_SERVER["HTTP_REFERER"])) {
        $returnurl = $_SERVER["HTTP_REFERER"];
    } else {
        $returnurl = new lion_url('/mod/wiki/files.php', array('subwiki'=>$subwiki->id));
    }
}

$title = get_string('editfiles', 'wiki');

$struser = get_string('user');
$url = new lion_url('/mod/wiki/filesedit.php', array('subwiki'=>$subwiki->id, 'pageid'=>$pageid));
$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_title($title);
$PAGE->set_heading($course->fullname);
$PAGE->navbar->add(format_string(get_string('wikifiles', 'wiki')), $CFG->wwwroot . '/mod/wiki/files.php?pageid=' . $pageid);
$PAGE->navbar->add(format_string($title));

$data = new stdClass();
$data->returnurl = $returnurl;
$data->subwikiid = $subwiki->id;
$maxbytes = get_max_upload_file_size($CFG->maxbytes, $COURSE->maxbytes);
$options = array('subdirs'=>0, 'maxbytes'=>$maxbytes, 'maxfiles'=>-1, 'accepted_types'=>'*', 'return_types'=>FILE_INTERNAL | FILE_REFERENCE);
file_prepare_standard_filemanager($data, 'files', $options, $context, 'mod_wiki', 'attachments', $subwiki->id);

$mform = new mod_wiki_filesedit_form(null, array('data'=>$data, 'options'=>$options));

if ($mform->is_cancelled()) {
    redirect($returnurl);
} else if ($formdata = $mform->get_data()) {
    $formdata = file_postupdate_standard_filemanager($formdata, 'files', $options, $context, 'mod_wiki', 'attachments', $subwiki->id);
    redirect($returnurl);
}

echo $OUTPUT->header();
echo $OUTPUT->heading(format_string($wiki->name));
echo $OUTPUT->box(format_module_intro('wiki', $wiki, $PAGE->cm->id), 'generalbox', 'intro');
echo $OUTPUT->box_start('generalbox');
$mform->display();
echo $OUTPUT->box_end();
echo $OUTPUT->footer();
