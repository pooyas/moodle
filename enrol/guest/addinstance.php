<?php

/**
 * Adds new instance of enrol_guest to specified course.
 *
 * @package    enrol_guest
 * @copyright  2010 Petr Skoda  {@link http://skodak.org}
 * 
 */

require('../../config.php');

$id = required_param('id', PARAM_INT); // course id

$course = $DB->get_record('course', array('id'=>$id), '*', MUST_EXIST);
$context = context_course::instance($course->id, MUST_EXIST);

require_login($course);
require_capability('lion/course:enrolconfig', $context);
require_sesskey();

$enrol = enrol_get_plugin('guest');

if ($enrol->get_newinstance_link($course->id)) {
    $enrol->add_default_instance($course);
}

redirect(new lion_url('/enrol/instances.php', array('id'=>$course->id)));
