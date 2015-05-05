<?php

/**
 * Move/order course functionality for course_overview block.
 *
 * @package    block
 * @subpackage course_overview
 * @copyright  2015 Pooya Saeedi
 * 
 */
require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(__FILE__) . '/locallib.php');

require_sesskey();
require_login();

$coursetomove = required_param('courseid', PARAM_INT);
$moveto = required_param('moveto', PARAM_INT);

list($courses, $sitecourses, $coursecount) = block_course_overview_get_sorted_courses();
$sortedcourses = array_keys($courses);

$currentcourseindex = array_search($coursetomove, $sortedcourses);
// If coursetomove is not found or moveto < 0 or > count($sortedcourses) then throw error.
if ($currentcourseindex === false) {
    print_error("invalidcourseid", null, null, $coursetomove);
} else if (($moveto < 0) || ($moveto >= count($sortedcourses))) {
    print_error("invalidaction");
}

// If current course index is same as destination index then don't do anything.
if ($currentcourseindex === $moveto) {
    redirect(new lion_url('/my/index.php'));
}

// Create neworder list for courses.
$neworder = array();

unset($sortedcourses[$currentcourseindex]);
$neworder = array_slice($sortedcourses, 0, $moveto, true);
$neworder[] = $coursetomove;
$remaningcourses = array_slice($sortedcourses, $moveto);
foreach ($remaningcourses as $courseid) {
    $neworder[] = $courseid;
}
block_course_overview_update_myorder(array_values($neworder));
redirect(new lion_url('/my/index.php'));
