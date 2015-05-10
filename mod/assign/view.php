<?php

/**
 * This file is the entry point to the assign module. All pages are rendered from here
 *
 * @package   mod
 * @subpackage assign
 * @copyright 2015 Pooya Saeedi 
 * 
 */

require_once('../../config.php');
require_once($CFG->dirroot . '/mod/assign/locallib.php');

$id = required_param('id', PARAM_INT);

$urlparams = array('id' => $id,
                  'action' => optional_param('action', '', PARAM_TEXT),
                  'rownum' => optional_param('rownum', 0, PARAM_INT),
                  'useridlistid' => optional_param('action', 0, PARAM_INT));

$url = new lion_url('/mod/assign/view.php', $urlparams);

list ($course, $cm) = get_course_and_cm_from_cmid($id, 'assign');

require_login($course, true, $cm);
$PAGE->set_url($url);

$context = context_module::instance($cm->id);

require_capability('mod/assign:view', $context);

$assign = new assign($context, $cm, $course);

$completion=new completion_info($course);
$completion->set_module_viewed($cm);

// Get the assign class to
// render the page.
echo $assign->view(optional_param('action', '', PARAM_TEXT));
