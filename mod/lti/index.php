<?php


/**
 * @package    mod
 * @subpackage lti
 * @copyright  2015 Pooya Saeedi
*/

//
// This file is part of BasicLTI4Lion
//
// BasicLTI4Lion is an IMS BasicLTI (Basic Learning Tools for Interoperability)
// consumer for Lion 1.9 and Lion 2.0. BasicLTI is a IMS Standard that allows web
// based learning tools to be easily integrated in LMS as native ones. The IMS BasicLTI
// specification is part of the IMS standard Common Cartridge 1.1 Sakai and other main LMS
// are already supporting or going to support BasicLTI. This project Implements the consumer
// for Lion. Lion is a Free Open source Learning Management System by Martin Dougiamas.
// BasicLTI4Lion is a project iniciated and leaded by Ludo(Marc Alier) and Jordi Piguillem
// at the GESSI research group at UPC.
// SimpleLTI consumer for Lion is an implementation of the early specification of LTI
// by Charles Severance (Dr Chuck) htp://dr-chuck.com , developed by Jordi Piguillem in a
// Google Summer of Code 2008 project co-mentored by Charles Severance and Marc Alier.
//
// BasicLTI4Lion is copyright 2009 by Marc Alier Forment, Jordi Piguillem and Nikolas Galanis
// of the Universitat Politecnica de Catalunya http://www.upc.edu
// Contact info: Marc Alier Forment granludo @ gmail.com or marc.alier @ upc.edu.

/**
 * This page lists all the instances of lti in a particular course
 *
 *  marc.alier@upc.edu
 */
require_once("../../config.php");
require_once($CFG->dirroot.'/mod/lti/lib.php');

$id = required_param('id', PARAM_INT);   // Course id.

$course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);

require_login($course);
$PAGE->set_pagelayout('incourse');

$params = array(
    'context' => context_course::instance($course->id)
);
$event = \mod_lti\event\course_module_instance_list_viewed::create($params);
$event->add_record_snapshot('course', $course);
$event->trigger();

$PAGE->set_url('/mod/lti/index.php', array('id' => $course->id));
$pagetitle = strip_tags($course->shortname.': '.get_string("modulenamepluralformatted", "lti"));
$PAGE->set_title($pagetitle);
$PAGE->set_heading($course->fullname);

echo $OUTPUT->header();

// Print the main part of the page.
echo $OUTPUT->heading(get_string("modulenamepluralformatted", "lti"));

// Get all the appropriate data.
if (! $basicltis = get_all_instances_in_course("lti", $course)) {
    notice(get_string('noltis', 'lti'), "../../course/view.php?id=$course->id");
    die;
}

// Print the list of instances (your module will probably extend this).
$timenow = time();
$strname = get_string("name");
$usesections = course_format_uses_sections($course->format);

$table = new html_table();
$table->attributes['class'] = 'generaltable mod_index';

if ($usesections) {
    $strsectionname = get_string('sectionname', 'format_'.$course->format);
    $table->head  = array ($strsectionname, $strname);
    $table->align = array ("center", "left");
} else {
    $table->head  = array ($strname);
}

foreach ($basicltis as $basiclti) {
    if (!$basiclti->visible) {
        // Show dimmed if the mod is hidden.
        $link = "<a class=\"dimmed\" href=\"view.php?id=$basiclti->coursemodule\">$basiclti->name</a>";
    } else {
        // Show normal if the mod is visible.
        $link = "<a href=\"view.php?id=$basiclti->coursemodule\">$basiclti->name</a>";
    }

    if ($usesections) {
        $table->data[] = array (get_section_name($course, $basiclti->section), $link);
    } else {
        $table->data[] = array ($link);
    }
}

echo "<br />";

echo html_writer::table($table);

// Finish the page.
echo $OUTPUT->footer();
