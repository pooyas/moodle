<?php


/**
 * Allows a user to request a course be created for them.
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * 
 * @package course
 */

require_once(dirname(__FILE__) . '/../config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/request_form.php');

// Where we came from. Used in a number of redirects.
$url = new lion_url('/course/request.php');
$return = optional_param('return', null, PARAM_ALPHANUMEXT);
if ($return === 'management') {
    $url->param('return', $return);
    $returnurl = new lion_url('/course/management.php', array('categoryid' => $CFG->defaultrequestcategory));
} else {
    $returnurl = new lion_url('/course/index.php');
}

$PAGE->set_url($url);

// Check permissions.
require_login(null, false);
if (isguestuser()) {
    print_error('guestsarenotallowed', '', $returnurl);
}
if (empty($CFG->enablecourserequests)) {
    print_error('courserequestdisabled', '', $returnurl);
}
$context = context_system::instance();
$PAGE->set_context($context);
require_capability('lion/course:request', $context);

// Set up the form.
$data = course_request::prepare();
$requestform = new course_request_form($url, compact('editoroptions'));
$requestform->set_data($data);

$strtitle = get_string('courserequest');
$PAGE->set_title($strtitle);
$PAGE->set_heading($strtitle);

// Standard form processing if statement.
if ($requestform->is_cancelled()){
    redirect($returnurl);

} else if ($data = $requestform->get_data()) {
    $request = course_request::create($data);

    // And redirect back to the course listing.
    notice(get_string('courserequestsuccess'), $returnurl);
}

$PAGE->navbar->add($strtitle);
echo $OUTPUT->header();
echo $OUTPUT->heading($strtitle);
// Show the request form.
$requestform->display();
echo $OUTPUT->footer();
