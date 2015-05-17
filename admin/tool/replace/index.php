<?php


/**
 * Search and replace strings throughout all texts in the whole database
 *
 * @package    admin_tool
 * @subpackage replace
 * @copyright  2015 Pooya Saeedi
 */

define('NO_OUTPUT_BUFFERING', true);

require_once('../../../config.php');
require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->libdir.'/adminlib.php');

admin_externalpage_setup('toolreplace');

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('pageheader', 'tool_replace'));

if (!$DB->replace_all_text_supported()) {
    echo $OUTPUT->notification(get_string('notimplemented', 'tool_replace'));
    echo $OUTPUT->footer();
    die;
}

echo $OUTPUT->box_start();
echo $OUTPUT->notification(get_string('notsupported', 'tool_replace'));
echo $OUTPUT->notification(get_string('excludedtables', 'tool_replace'));
echo $OUTPUT->box_end();

$form = new tool_replace_form();

if (!$data = $form->get_data()) {
    $form->display();
    echo $OUTPUT->footer();
    die();
}

// Scroll to the end when finished.
$PAGE->requires->js_init_code("window.scrollTo(0, 5000000);");

echo $OUTPUT->box_start();
db_replace($data->search, $data->replace);
echo $OUTPUT->box_end();

// Course caches are now rebuilt on the fly.

echo $OUTPUT->continue_button(new lion_url('/admin/index.php'));

echo $OUTPUT->footer();
