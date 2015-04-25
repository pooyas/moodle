<?php

/**
 * This script allows the number of sections in a course to be increased
 * or decreased, redirecting to the course page.
 *
 * @package core
 * @subpackage course
 * @copyright 2015 Pooya Saeedi
 */

// Note:
// Renaming required

require_once(dirname(__FILE__).'/../config.php');
require_once($CFG->dirroot.'/course/lib.php');

$courseid = required_param('courseid', PARAM_INT);
$increase = optional_param('increase', true, PARAM_BOOL);
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$courseformatoptions = course_get_format($course)->get_format_options();

$PAGE->set_url('/course/changenumsections.php', array('courseid' => $courseid));

// Authorisation checks.
require_login($course);
require_capability('moodle/course:update', context_course::instance($course->id));
require_sesskey();

if (isset($courseformatoptions['numsections'])) {
    if ($increase) {
        // Add an additional section.
        $courseformatoptions['numsections']++;
    } else {
        // Remove a section.
        $courseformatoptions['numsections']--;
    }

    // Don't go less than 0, intentionally redirect silently (for the case of
    // double clicks).
    if ($courseformatoptions['numsections'] >= 0) {
        update_course((object)array('id' => $course->id,
            'numsections' => $courseformatoptions['numsections']));
    }
}

$url = course_get_url($course);
$url->set_anchor('changenumsections');
// Redirect to where we were..
redirect($url);
