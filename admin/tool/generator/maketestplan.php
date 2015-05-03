<?php

/**
 * Generates a JMeter test plan to performance comparison.
 *
 * @package tool_generator
 * @copyright 2015 Pooya Saeedi
 * 
 */

require(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');

// Initialise page and check permissions.
admin_externalpage_setup('toolgeneratortestplan');

// Start page.
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('maketestplan', 'tool_generator'));

// Information message.
$context = context_system::instance();
$markdownlink = '[' . tool_generator_testplan_backend::get_repourl() . '](' . tool_generator_testplan_backend::get_repourl() . ')';
echo $OUTPUT->box(format_text(get_string('testplanexplanation', 'tool_generator', $markdownlink),
        FORMAT_MARKDOWN, array('context' => $context)));

// Check debugging is set to DEVELOPER.
if (!$CFG->debugdeveloper) {
    echo $OUTPUT->notification(get_string('error_notdebugging', 'tool_generator'));
    echo $OUTPUT->footer();
    exit;
}

// Set up the form.
$mform = new tool_generator_make_testplan_form('maketestplan.php');
if ($data = $mform->get_data()) {

    // Creating both test plan and users files.
    $testplanfile = tool_generator_testplan_backend::create_testplan_file($data->courseid, $data->size);
    $usersfile = tool_generator_testplan_backend::create_users_file($data->courseid, $data->updateuserspassword);

    // Test plan link.
    $testplanurl = lion_url::make_pluginfile_url(
        $testplanfile->get_contextid(),
        $testplanfile->get_component(),
        $testplanfile->get_filearea(),
        $testplanfile->get_itemid(),
        $testplanfile->get_filepath(),
        $testplanfile->get_filename()
    );
    echo html_writer::div(
        html_writer::link($testplanurl, get_string('downloadtestplan', 'tool_generator'))
    );

    // Users file link.
    $usersfileurl = lion_url::make_pluginfile_url(
        $usersfile->get_contextid(),
        $usersfile->get_component(),
        $usersfile->get_filearea(),
        $usersfile->get_itemid(),
        $usersfile->get_filepath(),
        $usersfile->get_filename()
    );
    echo html_writer::div(
        html_writer::link($usersfileurl, get_string('downloadusersfile', 'tool_generator'))
    );

} else {
    // Display form.
    $mform->display();
}

echo $OUTPUT->footer();
