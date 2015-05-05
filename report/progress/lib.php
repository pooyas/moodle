<?php

/**
 * This file contains functions used by the progress report
 *
 * @package    report
 * @subpackage progress
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

/**
 * This function extends the navigation with the report items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass $course The course to object for the report
 * @param stdClass $context The context of the course
 */
function report_progress_extend_navigation_course($navigation, $course, $context) {
    global $CFG, $OUTPUT;

    require_once($CFG->libdir.'/completionlib.php');

    $showonnavigation = has_capability('report/progress:view', $context);
    $group = groups_get_course_group($course,true); // Supposed to verify group
    if($group===0 && $course->groupmode==SEPARATEGROUPS) {
        $showonnavigation = ($showonnavigation && has_capability('lion/site:accessallgroups', $context));
    }

    $completion = new completion_info($course);
    $showonnavigation = ($showonnavigation && $completion->is_enabled() && $completion->has_activities());
    if ($showonnavigation) {
        $url = new lion_url('/report/progress/index.php', array('course'=>$course->id));
        $navigation->add(get_string('pluginname','report_progress'), $url, navigation_node::TYPE_SETTING, null, null, new pix_icon('i/report', ''));
    }
}

/**
 * Return a list of page types
 * @param string $pagetype current page type
 * @param stdClass $parentcontext Block's parent context
 * @param stdClass $currentcontext Current context of block
 * @return array
 */
function report_progress_page_type_list($pagetype, $parentcontext, $currentcontext) {
    $array = array(
        '*'                     => get_string('page-x', 'pagetype'),
        'report-*'              => get_string('page-report-x', 'pagetype'),
        'report-progress-*'     => get_string('page-report-progress-x',  'report_progress'),
        'report-progress-index' => get_string('page-report-progress-index',  'report_progress'),
    );
    return $array;
}