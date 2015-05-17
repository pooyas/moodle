<?php



/**
 * Allows a creator to edit custom scales, and also display help about scales
 *
 * @deprecated - TODO remove this file or replace it with an alternative solution for scales overview
 * @package    core
 * @subpackage course
 * @copyright  2015 Pooya Saeedi
 */

require_once("../config.php");
require_once("lib.php");

$id   = required_param('id', PARAM_INT);               // course id
$scaleid  = optional_param('scaleid', 0, PARAM_INT);   // scale id (show only this one)

$url = new lion_url('/course/scales.php', array('id'=>$id));
if ($scaleid !== 0) {
    $url->param('scaleid', $scaleid);
}
$PAGE->set_url($url);

$context = null;
if ($course = $DB->get_record('course', array('id'=>$id))) {
    require_login($course);
    $context = context_course::instance($course->id);
} else {
    //$id will be 0 for site level scales
    require_login();
    $context = context_system::instance();
}

$PAGE->set_context($context);
require_capability('lion/course:viewscales', $context);

$strscales = get_string("scales");
$strcustomscales = get_string("scalescustom");
$strstandardscales = get_string("scalesstandard");

$PAGE->set_title($strscales);
if (!empty($course)) {
    $PAGE->set_heading($course->fullname);
} else {
    $PAGE->set_heading($SITE->fullname);
}
echo $OUTPUT->header();

if ($scaleid) {
    if ($scale = $DB->get_record("scale", array('id'=>$scaleid))) {
        if ($scale->courseid == 0 || $scale->courseid == $course->id) {

            $scalemenu = make_menu_from_list($scale->scale);

            echo $OUTPUT->box_start();
            echo $OUTPUT->heading($scale->name);
            echo "<center>";
            echo html_writer::label(get_string('scales'), 'scaleunused'. $scaleid, false, array('class' => 'accesshide'));
            echo html_writer::select($scalemenu, 'unused', '', array('' => 'choosedots'), array('id' => 'scaleunused'.$scaleid));
            echo "</center>";
            echo text_to_html($scale->description);
            echo $OUTPUT->box_end();
            echo $OUTPUT->close_window_button();
            echo $OUTPUT->footer();
            exit;
        }
    }
}

$systemcontext = context_system::instance();

if ($scales = $DB->get_records("scale", array("courseid"=>$course->id), "name ASC")) {
    echo $OUTPUT->heading($strcustomscales);

    if (has_capability('lion/course:managescales', $context)) {
        echo "<p align=\"center\">(";
        print_string('scalestip2');
        echo ")</p>";
    }

    foreach ($scales as $scale) {

        $scale->description = file_rewrite_pluginfile_urls($scale->description, 'pluginfile.php', $systemcontext->id, 'grade', 'scale', $scale->id);

        $scalemenu = make_menu_from_list($scale->scale);

        echo $OUTPUT->box_start();
        echo $OUTPUT->heading($scale->name);
        echo "<center>";
        echo html_writer::label(get_string('scales'), 'courseunused' . $scale->id, false, array('class' => 'accesshide'));
        echo html_writer::select($scalemenu, 'unused', '', array('' => 'choosedots'), array('id' => 'courseunused' . $scale->id));
        echo "</center>";
        echo text_to_html($scale->description);
        echo $OUTPUT->box_end();
        echo "<hr />";
    }

} else {
    if (has_capability('lion/course:managescales', $context)) {
        echo "<p align=\"center\">(";
        print_string("scalestip2");
        echo ")</p>";
    }
}

if ($scales = $DB->get_records("scale", array("courseid"=>0), "name ASC")) {
    echo $OUTPUT->heading($strstandardscales);
    foreach ($scales as $scale) {

        $scale->description = file_rewrite_pluginfile_urls($scale->description, 'pluginfile.php', $systemcontext->id, 'grade', 'scale', $scale->id);

        $scalemenu = make_menu_from_list($scale->scale);

        echo $OUTPUT->box_start();
        echo $OUTPUT->heading($scale->name);
        echo "<center>";
        echo html_writer::label(get_string('scales'), 'sitescale' . $scale->id, false, array('class' => 'accesshide'));
        echo html_writer::select($scalemenu, 'unused', '', array('' => 'choosedots'), array('id' => 'sitescale' . $scale->id));
        echo "</center>";
        echo text_to_html($scale->description);
        echo $OUTPUT->box_end();
        echo "<hr />";
    }
}

echo $OUTPUT->close_window_button();
echo $OUTPUT->footer();

