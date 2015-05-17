<?php


/**
 * Book import
 *
 * @package    mod
 * @subpackage book
 * @copyright  2015 Pooya Saeedi
 */

require(dirname(__FILE__).'/../../../../config.php');
require_once(dirname(__FILE__).'/locallib.php');
require_once(dirname(__FILE__).'/import_form.php');

$id        = required_param('id', PARAM_INT);           // Course Module ID
$chapterid = optional_param('chapterid', 0, PARAM_INT); // Chapter ID

$cm = get_coursemodule_from_id('book', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id'=>$cm->course), '*', MUST_EXIST);
$book = $DB->get_record('book', array('id'=>$cm->instance), '*', MUST_EXIST);

require_login($course, false, $cm);

$context = context_module::instance($cm->id);
require_capability('booktool/importhtml:import', $context);

$PAGE->set_url('/mod/book/tool/importhtml/index.php', array('id'=>$id, 'chapterid'=>$chapterid));

if ($chapterid) {
    if (!$chapter = $DB->get_record('book_chapters', array('id'=>$chapterid, 'bookid'=>$book->id))) {
        $chapterid = 0;
    }
} else {
    $chapter = false;
}

$PAGE->set_title($book->name);
$PAGE->set_heading($course->fullname);

// Prepare the page header.
$strbook = get_string('modulename', 'mod_book');
$strbooks = get_string('modulenameplural', 'mod_book');

$mform = new booktool_importhtml_form(null, array('id'=>$id, 'chapterid'=>$chapterid));

// If data submitted, then process and store.
if ($mform->is_cancelled()) {
    if (empty($chapter->id)) {
        redirect($CFG->wwwroot."/mod/book/view.php?id=$cm->id");
    } else {
        redirect($CFG->wwwroot."/mod/book/view.php?id=$cm->id&chapterid=$chapter->id");
    }

} else if ($data = $mform->get_data()) {
    echo $OUTPUT->header();
    echo $OUTPUT->heading($book->name);
    echo $OUTPUT->heading(get_string('importingchapters', 'booktool_importhtml'), 3);

    // this is a bloody hack - children do not try this at home!
    $fs = get_file_storage();
    $draftid = file_get_submitted_draft_itemid('importfile');
    if (!$files = $fs->get_area_files(context_user::instance($USER->id)->id, 'user', 'draft', $draftid, 'id DESC', false)) {
        redirect($PAGE->url);
    }
    $file = reset($files);
    toolbook_importhtml_import_chapters($file, $data->type, $book, $context);

    echo $OUTPUT->continue_button(new lion_url('/mod/book/view.php', array('id'=>$id)));
    echo $OUTPUT->footer();
    die;
}

echo $OUTPUT->header();
echo $OUTPUT->heading($book->name);

$mform->display();

echo $OUTPUT->footer();
