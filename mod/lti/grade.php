<?php

/**
 * This file contains submissions-specific code for the lti module
 *
 * @package mod
 * @subpackage lti
 * @copyright  2015 Pooya Saeedi
 * 
 * @deprecated since 2.8
 */

require_once(dirname(dirname(__DIR__)).'/config.php');

$id = optional_param('id', 0, PARAM_INT);
$l  = optional_param('l', 0, PARAM_INT);

if ($l) {
    $lti = $DB->get_record('lti', array('id' => $l), '*', MUST_EXIST);
    $cm = get_coursemodule_from_instance('lti', $lti->id, $lti->course, false, MUST_EXIST);
} else {
    $cm = get_coursemodule_from_id('lti', $id, 0, false, MUST_EXIST);
    $lti = $DB->get_record('lti', array('id' => $cm->instance), '*', MUST_EXIST);
}

$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);

require_login($course, false, $cm);
require_capability('mod/lti:view', context_module::instance($cm->id));

debugging('This file has been deprecated.  Links to this file should automatically '.
    'fallback to /mod/lti/view.php once this file has been deleted.', DEBUG_DEVELOPER);

redirect(new lion_url('/mod/lti/view.php', array('l' => $lti->id)));
