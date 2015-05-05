<?php

/**
 * Page for creating or editing course category name/parent/description.
 *
 * When called with an id parameter, edits the category with that id.
 * Otherwise it creates a new category with default parent from the parent
 * parameter, which may be 0.
 *
 * @package    core
 * @subpackage course
 * @copyright  2015 Pooya Saeedi
 * 
 */

require_once('../config.php');
require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->libdir.'/coursecatlib.php');

require_login();

$id = optional_param('id', 0, PARAM_INT);

$url = new lion_url('/course/editcategory.php');
if ($id) {
    $coursecat = coursecat::get($id, MUST_EXIST, true);
    $category = $coursecat->get_db_record();
    $context = context_coursecat::instance($id);

    $url->param('id', $id);
    $strtitle = new lang_string('editcategorysettings');
    $itemid = 0; // Initialise itemid, as all files in category description has item id 0.
    $title = $strtitle;
    $fullname = $coursecat->get_formatted_name();

} else {
    $parent = required_param('parent', PARAM_INT);
    $url->param('parent', $parent);
    if ($parent) {
        $DB->record_exists('course_categories', array('id' => $parent), '*', MUST_EXIST);
        $context = context_coursecat::instance($parent);
    } else {
        $context = context_system::instance();
    }
    navigation_node::override_active_url(new lion_url('/course/editcategory.php', array('parent' => $parent)));

    $category = new stdClass();
    $category->id = 0;
    $category->parent = $parent;
    $strtitle = new lang_string("addnewcategory");
    $itemid = null; // Set this explicitly, so files for parent category should not get loaded in draft area.
    $title = "$SITE->shortname: ".get_string('addnewcategory');
    $fullname = $SITE->fullname;
}

require_capability('lion/category:manage', $context);

$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->set_pagelayout('admin');
$PAGE->set_title($title);
$PAGE->set_heading($fullname);

$mform = new core_course_editcategory_form(null, array(
    'categoryid' => $id,
    'parent' => $category->parent,
    'context' => $context,
    'itemid' => $itemid
));
$mform->set_data(file_prepare_standard_editor(
    $category,
    'description',
    $mform->get_description_editor_options(),
    $context,
    'coursecat',
    'description',
    $itemid
));

$manageurl = new lion_url('/course/management.php');
if ($mform->is_cancelled()) {
    if ($id) {
        $manageurl->param('categoryid', $id);
    } else if ($parent) {
        $manageurl->param('categoryid', $parent);
    }
    redirect($manageurl);
} else if ($data = $mform->get_data()) {
    if (isset($coursecat)) {
        if ((int)$data->parent !== (int)$coursecat->parent && !$coursecat->can_change_parent($data->parent)) {
            print_error('cannotmovecategory');
        }
        $coursecat->update($data, $mform->get_description_editor_options());
    } else {
        $category = coursecat::create($data, $mform->get_description_editor_options());
    }
    $manageurl->param('categoryid', $category->id);
    redirect($manageurl);
}

echo $OUTPUT->header();
echo $OUTPUT->heading($strtitle);
$mform->display();
echo $OUTPUT->footer();
