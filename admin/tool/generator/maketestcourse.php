<?php


/**
 * Script creates a standardised large course for testing reliability and performance.
 *
 * @package    admin_tool
 * @subpackage generator
 * @copyright  2015 Pooya Saeedi
 */

// Disable buffering so that the progress output displays gradually without
// needing to call flush().
define('NO_OUTPUT_BUFFERING', true);

require('../../../config.php');

require_once($CFG->libdir . '/adminlib.php');

// Initialise page and check permissions.
admin_externalpage_setup('toolgeneratorcourse');

// Start page.
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('maketestcourse', 'tool_generator'));

// Information message.
$context = context_system::instance();
echo $OUTPUT->box(format_text(get_string('courseexplanation', 'tool_generator'),
        FORMAT_MARKDOWN, array('context' => $context)));

// Check debugging is set to DEVELOPER.
if (!debugging('', DEBUG_DEVELOPER)) {
    echo $OUTPUT->notification(get_string('error_notdebugging', 'tool_generator'));
    echo $OUTPUT->footer();
    exit;
}

// Set up the form.
$mform = new tool_generator_make_course_form('maketestcourse.php');
if ($data = $mform->get_data()) {
    // Do actual work.
    echo $OUTPUT->heading(get_string('creating', 'tool_generator'));
    $backend = new tool_generator_course_backend(
        $data->shortname,
        $data->size,
        false,
        false,
        true,
        $data->fullname,
        $data->summary['text'],
        $data->summary['format']
    );
    $id = $backend->make();

    echo html_writer::div(
            html_writer::link(new lion_url('/course/view.php', array('id' => $id)),
                get_string('continue')));
} else {
    // Display form.
    $mform->display();
}

// Finish page.
echo $OUTPUT->footer();
