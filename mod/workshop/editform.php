<?php


/**
 * Edit grading form in for a particular instance of workshop
 *
 * @package    mod_workshop
 * @copyright  2009 David Mudrak <david.mudrak@gmail.com>
 * 
 */

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/locallib.php');

$cmid       = required_param('cmid', PARAM_INT);

$cm         = get_coursemodule_from_id('workshop', $cmid, 0, false, MUST_EXIST);
$course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);

require_login($course, false, $cm);
require_capability('mod/workshop:editdimensions', $PAGE->context);

$workshop   = $DB->get_record('workshop', array('id' => $cm->instance), '*', MUST_EXIST);
$workshop   = new workshop($workshop, $cm, $course);

// todo: check if there already is some assessment done and do not allowed the change of the form
// once somebody already used it to assess

$PAGE->set_url($workshop->editform_url());
$PAGE->set_title($workshop->name);
$PAGE->set_heading($course->fullname);
$PAGE->navbar->add(get_string('editingassessmentform', 'workshop'));

// load the grading strategy logic
$strategy = $workshop->grading_strategy_instance();

// load the form to edit the grading strategy dimensions
$mform = $strategy->get_edit_strategy_form($PAGE->url);

if ($mform->is_cancelled()) {
    redirect($workshop->view_url());
} elseif ($data = $mform->get_data()) {
    if (($data->workshopid != $workshop->id) or ($data->strategy != $workshop->strategy)) {
        // this may happen if someone changes the workshop setting while the user had the
        // editing form opened
        throw new invalid_parameter_exception('Invalid workshop ID or the grading strategy has changed.');
    }
    $strategy->save_edit_strategy_form($data);
    if (isset($data->saveandclose)) {
        redirect($workshop->view_url());
    } elseif (isset($data->saveandpreview)) {
        redirect($workshop->previewform_url());
    } else {
        // save and continue - redirect to self to prevent data being re-posted by pressing "Reload"
        redirect($PAGE->url);
    }
}

// Output starts here

echo $OUTPUT->header();
echo $OUTPUT->heading(format_string($workshop->name));
echo $OUTPUT->heading(get_string('pluginname', 'workshopform_' . $workshop->strategy), 3);

$mform->display();

echo $OUTPUT->footer();
