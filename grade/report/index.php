<?php

/**
 * Redirects the user to the default grade report
 *
 * @package    grade
 * @subpackage report
 * @copyright  2015 Pooya Saeedi
 * 
 */

require_once '../../config.php';

$courseid = required_param('id', PARAM_INT);

$PAGE->set_url('/grade/report/index.php', array('id'=>$courseid));

/// basic access checks
if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('nocourseid');
}
require_login($course);
$context = context_course::instance($course->id);

/// find all accessible reports
$reports = core_component::get_plugin_list('gradereport');     // Get all installed reports

foreach ($reports as $plugin => $plugindir) {                      // Remove ones we can't see
    if (!has_capability('gradereport/'.$plugin.':view', $context)) {
        unset($reports[$plugin]);
    }
}

if (empty($reports)) {
    print_error('noreports', 'debug', $CFG->wwwroot.'/course/view.php?id='.$course->id);
}

if (!isset($USER->grade_last_report)) {
    $USER->grade_last_report = array();
}

if (!empty($USER->grade_last_report[$course->id])) {
    $last = $USER->grade_last_report[$course->id];
} else {
    $last = null;
}

if (!array_key_exists($last, $reports)) {
    $last = null;
}

if (empty($last)) {
    if (array_key_exists('grader', $reports)) {
        $last = 'grader';

    } else if (array_key_exists($CFG->grade_profilereport, $reports)) {
        $last = $CFG->grade_profilereport;

    } else {
        reset($reports);
        $last = key($reports);
    }
}

//redirect to last or guessed report
redirect($CFG->wwwroot.'/grade/report/'.$last.'/index.php?id='.$course->id);

