<?php


/**
 * Lists the course categories
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package course
 */

require_once("../config.php");
require_once($CFG->dirroot. '/course/lib.php');
require_once($CFG->libdir. '/coursecatlib.php');

$categoryid = optional_param('categoryid', 0, PARAM_INT); // Category id
$site = get_site();

if ($categoryid) {
    $PAGE->set_category_by_id($categoryid);
    $PAGE->set_url(new lion_url('/course/index.php', array('categoryid' => $categoryid)));
    $PAGE->set_pagetype('course-index-category');
    // And the object has been loaded for us no need for another DB call
    $category = $PAGE->category;
} else {
    $categoryid = 0;
    $PAGE->set_url('/course/index.php');
    $PAGE->set_context(context_system::instance());
}

$PAGE->set_pagelayout('coursecategory');
$courserenderer = $PAGE->get_renderer('core', 'course');

if ($CFG->forcelogin) {
    require_login();
}

if ($categoryid && !$category->visible && !has_capability('lion/category:viewhiddencategories', $PAGE->context)) {
    throw new lion_exception('unknowncategory');
}

$PAGE->set_heading($site->fullname);
$content = $courserenderer->course_category($categoryid);

echo $OUTPUT->header();
echo $OUTPUT->skip_link_target();
echo $content;

echo $OUTPUT->footer();
