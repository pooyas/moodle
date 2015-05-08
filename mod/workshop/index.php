<?php


/**
 * Prints the list of all workshops in the course
 *
 * @package    mod_workshop
 * @copyright  2015 Pooya Saeedi
 * 
 */

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = required_param('id', PARAM_INT);   // course

$course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);

require_course_login($course);

$PAGE->set_pagelayout('incourse');
$PAGE->set_url('/mod/workshop/index.php', array('id' => $course->id));
$PAGE->set_title($course->fullname);
$PAGE->set_heading($course->shortname);
$PAGE->navbar->add(get_string('modulenameplural', 'workshop'));

/// Output starts here

echo $OUTPUT->header();

$params = array('context' => context_course::instance($course->id));
$event = \mod_workshop\event\course_module_instance_list_viewed::create($params);
$event->add_record_snapshot('course', $course);
$event->trigger();

/// Get all the appropriate data

if (! $workshops = get_all_instances_in_course('workshop', $course)) {
    echo $OUTPUT->heading(get_string('modulenameplural', 'workshop'));
    notice(get_string('noworkshops', 'workshop'), new lion_url('/course/view.php', array('id' => $course->id)));
    echo $OUTPUT->footer();
    die();
}

$usesections = course_format_uses_sections($course->format);

$timenow        = time();
$strname        = get_string('name');
$table          = new html_table();

if ($usesections) {
    $strsectionname = get_string('sectionname', 'format_'.$course->format);
    $table->head  = array ($strsectionname, $strname);
    $table->align = array ('center', 'left');
} else {
    $table->head  = array ($strname);
    $table->align = array ('left');
}

foreach ($workshops as $workshop) {
    if (empty($workshop->visible)) {
        $link = html_writer::link(new lion_url('/mod/workshop/view.php', array('id' => $workshop->coursemodule)),
                                  $workshop->name, array('class' => 'dimmed'));
    } else {
        $link = html_writer::link(new lion_url('/mod/workshop/view.php', array('id' => $workshop->coursemodule)),
                                  $workshop->name);
    }

    if ($usesections) {
        $table->data[] = array(get_section_name($course, $workshop->section), $link);
    } else {
        $table->data[] = array($link);
    }
}
echo $OUTPUT->heading(get_string('modulenameplural', 'workshop'), 3);
echo html_writer::table($table);
echo $OUTPUT->footer();
