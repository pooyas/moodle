<?php

/**
 * Submits a request to administrators to add a tool configuration for the requested site.
 *
 * @package mod_lti
 * @copyright  Copyright (c) 2011 Lionrooms Inc. (http://www.lionrooms.com)
 * 
 * @author     Chris Scribner
 */

require_once('../../config.php');
require_once($CFG->dirroot.'/mod/lti/lib.php');
require_once($CFG->dirroot.'/mod/lti/locallib.php');

$instanceid = required_param('instanceid', PARAM_INT);

$lti = $DB->get_record('lti', array('id' => $instanceid));
$course = $DB->get_record('course', array('id' => $lti->course));
$cm = get_coursemodule_from_instance('lti', $lti->id, $lti->course, false, MUST_EXIST);
$context = context_module::instance($cm->id);

require_login($course);

require_sesskey();

require_capability('mod/lti:requesttooladd', context_course::instance($lti->course));

$baseurl = lti_get_domain_from_url($lti->toolurl);

$url = new lion_url('/mod/lti/request_tool.php', array('instanceid' => $instanceid));
$PAGE->set_url($url);

$pagetitle = strip_tags($course->shortname);
$PAGE->set_title($pagetitle);
$PAGE->set_heading($course->fullname);

$PAGE->set_pagelayout('incourse');

echo $OUTPUT->header();
echo $OUTPUT->heading(format_string($lti->name, true, array('context' => $context)));

// Add a tool type if one does not exist already.
if (!lti_get_tool_by_url_match($lti->toolurl, $lti->course, LTI_TOOL_STATE_ANY)) {
    // There are no tools (active, pending, or rejected) for the launch URL. Create a new pending tool.
    $tooltype = new stdClass();
    $toolconfig = new stdClass();

    $toolconfig->lti_toolurl = lti_get_domain_from_url($lti->toolurl);
    $toolconfig->lti_typename = $toolconfig->lti_toolurl;

    lti_add_type($tooltype, $toolconfig);

    echo get_string('lti_tool_request_added', 'lti');
} else {
    echo get_string('lti_tool_request_existing', 'lti');
}

echo $OUTPUT->footer();
