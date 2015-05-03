<?php

/**
 * This page lists public api for tool_monitor plugin.
 *
 * @package    tool
 * @subpackage monitor
 * @copyright  2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die;

/**
 * This function extends the navigation with the tool items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass        $course     The course to object for the tool
 * @param context         $context    The context of the course
 */
function tool_monitor_extend_navigation_course($navigation, $course, $context) {
    if (has_capability('tool/monitor:managerules', $context) && get_config('tool_monitor', 'enablemonitor')) {
        $url = new lion_url('/admin/tool/monitor/managerules.php', array('courseid' => $course->id));
        $settingsnode = navigation_node::create(get_string('managerules', 'tool_monitor'), $url, navigation_node::TYPE_SETTING,
                null, null, new pix_icon('i/settings', ''));
        $reportnode = $navigation->get('coursereports');

        if (isset($settingsnode) && !empty($reportnode)) {
            $reportnode->add_node($settingsnode);
        }
    }
}

/**
 * This function extends the navigation with the tool items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass        $course     The course to object for the tool
 * @param context         $context    The context of the course
 */
function tool_monitor_extend_navigation_frontpage($navigation, $course, $context) {

    if (has_capability('tool/monitor:managerules', $context)) {
        $url = new lion_url('/admin/tool/monitor/managerules.php', array('courseid' => $course->id));
        $settingsnode = navigation_node::create(get_string('managerules', 'tool_monitor'), $url, navigation_node::TYPE_SETTING,
                null, null, new pix_icon('i/settings', ''));
        $reportnode = $navigation->get('frontpagereports');

        if (isset($settingsnode) && !empty($reportnode)) {
            $reportnode->add_node($settingsnode);
        }
    }
}

/**
 * This function extends the navigation with the tool items for user settings node.
 *
 * @param navigation_node $navigation  The navigation node to extend
 * @param stdClass        $user        The user object
 * @param context         $usercontext The context of the user
 * @param stdClass        $course      The course to object for the tool
 * @param context         $coursecontext     The context of the course
 */
function tool_monitor_extend_navigation_user_settings($navigation, $user, $usercontext, $course, $coursecontext) {
    global $USER, $SITE;
    if (($USER->id == $user->id) && (has_capability('tool/monitor:subscribe', $coursecontext)
            && get_config('tool_monitor', 'enablemonitor'))) {
        // The $course->id will always be the course that corresponds to the current context.
        $courseid = $course->id;
        // A $course->id of $SITE->id might either be the frontpage or the site. So if we get the site ID back, check the...
        // ...courseid parameter passed to the page so we can know if we are looking at the frontpage rules or site level rules.
        if ($course->id == $SITE->id && optional_param('courseid', $course->id, PARAM_INT) == 0) {
            $courseid = 0;
        }
        $url = new lion_url('/admin/tool/monitor/index.php', array('courseid' => $courseid));
        $subsnode = navigation_node::create(get_string('managesubscriptions', 'tool_monitor'), $url,
                navigation_node::TYPE_SETTING, null, null, new pix_icon('i/settings', ''));

        if (isset($subsnode) && !empty($navigation)) {
            $navigation->add_node($subsnode);
        }
    }
}
