<?php


/**
 * This file renders the quiz overview graph.
 *
 * @package    mod
 * @subpackage quiz
 * @copyright  2015 Pooya Saeedi
 */


require_once(dirname(__FILE__) . '/../../../../config.php');
require_once($CFG->libdir . '/graphlib.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->dirroot . '/mod/quiz/report/reportlib.php');

$quizid = required_param('id', PARAM_INT);
$groupid = optional_param('groupid', 0, PARAM_INT);

$quiz = $DB->get_record('quiz', array('id' => $quizid));
$course = $DB->get_record('course', array('id' => $quiz->course));
$cm = get_coursemodule_from_instance('quiz', $quizid);

require_login($course, false, $cm);
$modcontext = context_module::instance($cm->id);
require_capability('mod/quiz:viewreports', $modcontext);

if ($groupid && $groupmode = groups_get_activity_groupmode($cm)) {
    // Groups are being used.
    $groups = groups_get_activity_allowed_groups($cm);
    if (!array_key_exists($groupid, $groups)) {
        print_error('errorinvalidgroup', 'group', null, $groupid);
    }
    $group = $groups[$groupid];
    $groupusers = get_users_by_capability($modcontext,
            array('mod/quiz:reviewmyattempts', 'mod/quiz:attempt'),
            '', '', '', '', $group->id, '', false);
    if (!$groupusers) {
        print_error('nostudentsingroup');
    }
    $groupusers = array_keys($groupusers);
} else {
    $groupusers = array();
}

$line = new graph(800, 600);
$line->parameter['title'] = '';
$line->parameter['y_label_left'] = get_string('participants');
$line->parameter['x_label'] = get_string('grade');
$line->parameter['y_label_angle'] = 90;
$line->parameter['x_label_angle'] = 0;
$line->parameter['x_axis_angle'] = 60;

// The following two lines seem to silence notice warnings from graphlib.php.
$line->y_tick_labels = null;
$line->offset_relation = null;

// We will make size > 1 to get an overlap effect when showing groups.
$line->parameter['bar_size'] = 1;
// Don't forget to increase spacing so that graph doesn't become one big block of colour.
$line->parameter['bar_spacing'] = 10;

// Pick a sensible number of bands depending on quiz maximum grade.
$bands = $quiz->grade;
while ($bands > 20 || $bands <= 10) {
    if ($bands > 50) {
        $bands /= 5;
    } else if ($bands > 20) {
        $bands /= 2;
    }
    if ($bands < 4) {
        $bands *= 5;
    } else if ($bands <= 10) {
        $bands *= 2;
    }
}

// See MDL-34589. Using doubles as array keys causes problems in PHP 5.4,
// hence the explicit cast to int.
$bands = (int) ceil($bands);
$bandwidth = $quiz->grade / $bands;
$bandlabels = array();
for ($i = 1; $i <= $bands; $i++) {
    $bandlabels[] = quiz_format_grade($quiz, ($i - 1) * $bandwidth) . ' - ' .
            quiz_format_grade($quiz, $i * $bandwidth);
}
$line->x_data = $bandlabels;

$line->y_format['allusers'] = array(
    'colour' => 'red',
    'bar' => 'fill',
    'shadow_offset' => 1,
    'legend' => get_string('allparticipants')
);
$line->y_data['allusers'] = quiz_report_grade_bands($bandwidth, $bands, $quizid, $groupusers);

$line->y_order = array('allusers');

$ymax = max($line->y_data['allusers']);
$line->parameter['y_min_left'] = 0;
$line->parameter['y_max_left'] = $ymax;
$line->parameter['y_decimal_left'] = 0;

// Pick a sensible number of gridlines depending on max value on graph.
$gridlines = $ymax;
while ($gridlines >= 10) {
    if ($gridlines >= 50) {
        $gridlines /= 5;
    } else {
        $gridlines /= 2;
    }
}

$line->parameter['y_axis_gridlines'] = $gridlines + 1;
$line->draw();
