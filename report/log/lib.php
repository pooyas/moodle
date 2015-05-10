<?php

/**
 * Public API of the log report.
 *
 * Defines the APIs used by log reports
 *
 * @package    report
 * @subpackage log
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
function report_log_extend_navigation_course($navigation, $course, $context) {
    if (has_capability('report/log:view', $context)) {
        $url = new lion_url('/report/log/index.php', array('id'=>$course->id));
        $navigation->add(get_string('pluginname', 'report_log'), $url, navigation_node::TYPE_SETTING, null, null, new pix_icon('i/report', ''));
    }
}

/**
 * Callback to verify if the given instance of store is supported by this report or not.
 *
 * @param string $instance store instance.
 *
 * @return bool returns true if the store is supported by the report, false otherwise.
 */
function report_log_supports_logstore($instance) {
    if ($instance instanceof \core\log\sql_reader) {
        return true;
    }
    return false;
}

/**
 * This function extends the course navigation with the report items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass $user
 * @param stdClass $course The course to object for the report
 */
function report_log_extend_navigation_user($navigation, $user, $course) {
    list($all, $today) = report_log_can_access_user_report($user, $course);

    if ($today) {
        $url = new lion_url('/report/log/user.php', array('id'=>$user->id, 'course'=>$course->id, 'mode'=>'today'));
        $navigation->add(get_string('todaylogs'), $url);
    }
    if ($all) {
        $url = new lion_url('/report/log/user.php', array('id'=>$user->id, 'course'=>$course->id, 'mode'=>'all'));
        $navigation->add(get_string('alllogs'), $url);
    }
}

/**
 * Is current user allowed to access this report
 *
 * @access private defined in lib.php for performance reasons
 * @global stdClass $USER
 * @param stdClass $user
 * @param stdClass $course
 * @return array with two elements $all, $today
 */
function report_log_can_access_user_report($user, $course) {
    global $USER;

    $coursecontext = context_course::instance($course->id);
    $personalcontext = context_user::instance($user->id);

    $today = false;
    $all = false;

    if (has_capability('report/log:view', $coursecontext)) {
        $today = true;
    }
    if (has_capability('report/log:viewtoday', $coursecontext)) {
        $all = true;
    }

    if ($today and $all) {
        return array(true, true);
    }

    if (has_capability('lion/user:viewuseractivitiesreport', $personalcontext)) {
        if ($course->showreports and (is_viewing($coursecontext, $user) or is_enrolled($coursecontext, $user))) {
            return array(true, true);
        }

    } else if ($user->id == $USER->id) {
        if ($course->showreports and (is_viewing($coursecontext, $USER) or is_enrolled($coursecontext, $USER))) {
            return array(true, true);
        }
    }

    return array($all, $today);
}

/**
 * This function extends the module navigation with the report items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass $cm
 */
function report_log_extend_navigation_module($navigation, $cm) {
    if (has_capability('report/log:view', context_course::instance($cm->course))) {
        $url = new lion_url('/report/log/index.php', array('chooselog'=>'1','id'=>$cm->course,'modid'=>$cm->id));
        $navigation->add(get_string('logs'), $url, navigation_node::TYPE_SETTING, null, 'logreport');
    }
}

/**
 * Return a list of page types
 *
 * @param string $pagetype current page type
 * @param stdClass $parentcontext Block's parent context
 * @param stdClass $currentcontext Current context of block
 * @return array a list of page types
 */
function report_log_page_type_list($pagetype, $parentcontext, $currentcontext) {
    $array = array(
        '*'                => get_string('page-x', 'pagetype'),
        'report-*'         => get_string('page-report-x', 'pagetype'),
        'report-log-*'     => get_string('page-report-log-x',  'report_log'),
        'report-log-index' => get_string('page-report-log-index',  'report_log'),
        'report-log-user'  => get_string('page-report-log-user',  'report_log')
    );
    return $array;
}
