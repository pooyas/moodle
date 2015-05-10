<?php


/**
 * This page lists all the instances of wiki in a particular course
 *
 * @package mod
 * @subpackage wiki
 * @copyright 2015 Pooya Saeedi
 *
 * 
 */

require_once('../../config.php');
require_once('lib.php');

$id = required_param('id', PARAM_INT); // course
$PAGE->set_url('/mod/wiki/index.php', array('id' => $id));

if (!$course = $DB->get_record('course', array('id' => $id))) {
    print_error('invalidcourseid');
}

require_login($course, true);
$PAGE->set_pagelayout('incourse');
$context = context_course::instance($course->id);

$event = \mod_wiki\event\course_module_instance_list_viewed::create(array('context' => $context));
$event->add_record_snapshot('course', $course);
$event->trigger();

/// Get all required stringswiki
$strwikis = get_string("modulenameplural", "wiki");
$strwiki = get_string("modulename", "wiki");

/// Print the header
$PAGE->navbar->add($strwikis, "index.php?id=$course->id");
$PAGE->set_title($strwikis);
$PAGE->set_heading($course->fullname);
echo $OUTPUT->header();
echo $OUTPUT->heading($strwikis);

/// Get all the appropriate data
if (!$wikis = get_all_instances_in_course("wiki", $course)) {
    notice("There are no wikis", "../../course/view.php?id=$course->id");
    die;
}

$usesections = course_format_uses_sections($course->format);

/// Print the list of instances (your module will probably extend this)

$timenow = time();
$strname = get_string("name");
$table = new html_table();

if ($usesections) {
    $strsectionname = get_string('sectionname', 'format_' . $course->format);
    $table->head = array($strsectionname, $strname);
} else {
    $table->head = array($strname);
}

foreach ($wikis as $wiki) {
    $linkcss = null;
    if (!$wiki->visible) {
        $linkcss = array('class' => 'dimmed');
    }
    $link = html_writer::link(new lion_url('/mod/wiki/view.php', array('id' => $wiki->coursemodule)), $wiki->name, $linkcss);

    if ($usesections) {
        $table->data[] = array(get_section_name($course, $wiki->section), $link);
    } else {
        $table->data[] = array($link);
    }
}

echo html_writer::table($table);

/// Finish the page
echo $OUTPUT->footer();
