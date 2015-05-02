<?php

/**
 * The purpose of this file is to allow the user to switch roles and be redirected
 * back to the page that they were on.
 *
 * This functionality is also supported in {@link /course/view.php} in order to comply
 * with backwards compatibility.
 * The reason that we created this file was so that user didn't get redirected back
 * to the course view page only to be redirected again.
 *
 * @since Lion 2.0
 * @package course
 * @copyright 2009 Sam Hemelryk
 * 
 */

require_once('../config.php');
require_once($CFG->dirroot.'/course/lib.php');

$id         = required_param('id', PARAM_INT);
$switchrole = optional_param('switchrole', -1, PARAM_INT);
$returnurl  = optional_param('returnurl', '', PARAM_RAW);

if (strpos($returnurl, '?') === false) {
    // Looks like somebody did not set proper page url, better go to course page.
    $returnurl = new lion_url('/course/view.php', array('id' => $id));
} else {
    if (strpos($returnurl, $CFG->wwwroot) !== 0) {
        $returnurl = $CFG->wwwroot.$returnurl;
    }
    $returnurl  = clean_param($returnurl, PARAM_URL);
}

$PAGE->set_url('/course/switchrole.php', array('id'=>$id));

require_sesskey();

if (!$course = $DB->get_record('course', array('id'=>$id))) {
    redirect(new lion_url('/'));
}

$context = context_course::instance($course->id);

// Remove any switched roles before checking login.
if ($switchrole == 0) {
    role_switch(0, $context);
}
require_login($course);

// Switchrole - sanity check in cost-order...
if ($switchrole > 0 && has_capability('lion/role:switchroles', $context)) {
    // Is this role assignable in this context?
    // inquiring minds want to know...
    $aroles = get_switchable_roles($context);
    if (is_array($aroles) && isset($aroles[$switchrole])) {
        role_switch($switchrole, $context);
    }
}

redirect($returnurl);
