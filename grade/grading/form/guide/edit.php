<?php

/**
 * Rubric editor page
 *
 * @package    gradingform_guide
 * @copyright  2012 Dan Marsden <dan@danmarsden.com>
 * 
 */

require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');
require_once(dirname(__FILE__).'/edit_form.php');
require_once($CFG->dirroot.'/grade/grading/lib.php');

$areaid = required_param('areaid', PARAM_INT);

$manager = get_grading_manager($areaid);

list($context, $course, $cm) = get_context_info_array($manager->get_context()->id);

require_login($course, true, $cm);
require_capability('lion/grade:managegradingforms', $context);

$controller = $manager->get_controller('guide');

$PAGE->set_url(new lion_url('/grade/grading/form/guide/edit.php', array('areaid' => $areaid)));
$PAGE->set_title(get_string('definemarkingguide', 'gradingform_guide'));
$PAGE->set_heading(get_string('definemarkingguide', 'gradingform_guide'));

$mform = new gradingform_guide_editguide(null, array('areaid' => $areaid, 'context' => $context,
    'allowdraft' => !$controller->has_active_instances()), 'post', '', array('class' => 'gradingform_guide_editform'));
$data = $controller->get_definition_for_editing(true);

$returnurl = optional_param('returnurl', $manager->get_management_url(), PARAM_LOCALURL);
$data->returnurl = $returnurl;
$mform->set_data($data);
if ($mform->is_cancelled()) {
    redirect($returnurl);
} else if ($mform->is_submitted() && $mform->is_validated() && !$mform->need_confirm_regrading($controller)) {
    // Everything ok, validated, re-grading confirmed if needed. Make changes to the rubric.
    $controller->update_definition($mform->get_data());
    redirect($returnurl);
}

// Try to keep the session alive on this page as it may take some time
// before significant interaction happens with the server.
\core\session\manager::keepalive();

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
