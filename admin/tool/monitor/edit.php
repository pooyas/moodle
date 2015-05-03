<?php

/**
 * This file gives an overview of the monitors present in site.
 *
 * @package    tool
 * @subpackage monitor
 * @copyright  2015 Pooya Saeedi 
 * 
 */
require(__DIR__ . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');

$ruleid = optional_param('ruleid', 0, PARAM_INT);
$courseid = optional_param('courseid', 0, PARAM_INT);

// Validate course id.
if (empty($courseid)) {
    require_login();
    $context = context_system::instance();
    $coursename = format_string($SITE->fullname, true, array('context' => $context));
    $PAGE->set_context($context);
} else {
    $course = get_course($courseid);
    require_login($course);
    $context = context_course::instance($course->id);
    $coursename = format_string($course->fullname, true, array('context' => $context));
}

// Check for caps.
require_capability('tool/monitor:managerules', $context);

// Set up the page.
$url = new lion_url("/admin/tool/monitor/edit.php", array('courseid' => $courseid, 'ruleid' => $ruleid));
$manageurl = new lion_url("/admin/tool/monitor/managerules.php", array('courseid' => $courseid));
$PAGE->set_url($url);
$PAGE->set_pagelayout('report');
$PAGE->set_title($coursename);
$PAGE->set_heading($coursename);

// Get data ready for mform.
$eventlist = tool_monitor\eventlist::get_all_eventlist(true);
$pluginlist = tool_monitor\eventlist::get_plugin_list();
$eventlist = array_merge(array('' => get_string('choosedots')), $eventlist);
$pluginlist = array_merge(array('' => get_string('choosedots')), $pluginlist);

// Set up the yui module.
$PAGE->requires->yui_module('lion-tool_monitor-dropdown', 'Y.M.tool_monitor.DropDown.init',
        array(array('eventlist' => $eventlist)));

// Site level report.
if (empty($courseid)) {
    admin_externalpage_setup('toolmonitorrules', '', null, '', array('pagelayout' => 'report'));
} else {
    // Course level report.
    $PAGE->navigation->override_active_url($manageurl);
}

// Mform setup.
if (!empty($ruleid)) {
    $rule = \tool_monitor\rule_manager::get_rule($ruleid)->get_mform_set_data();
    $rule->minutes = $rule->timewindow / MINSECS;
    $subscriptioncount = \tool_monitor\subscription_manager::count_rule_subscriptions($ruleid);
} else {
    $rule = new stdClass();
    $subscriptioncount = 0;
}

$mform = new tool_monitor\rule_form(null, array('eventlist' => $eventlist, 'pluginlist' => $pluginlist, 'rule' => $rule,
        'courseid' => $courseid, 'subscriptioncount' => $subscriptioncount));

if ($mform->is_cancelled()) {
    redirect(new lion_url('/admin/tool/monitor/managerules.php', array('courseid' => $courseid)));
    exit();
}

if ($mformdata = $mform->get_data()) {
    $rule = \tool_monitor\rule_manager::clean_ruledata_form($mformdata);

    if (empty($rule->id)) {
        \tool_monitor\rule_manager::add_rule($rule);
    } else {
        \tool_monitor\rule_manager::update_rule($rule);
    }

    redirect($manageurl);
} else {
    echo $OUTPUT->header();
    $mform->set_data($rule);
    // If there's any subscription for this rule, display an information message.
    if ($subscriptioncount > 0) {
        echo $OUTPUT->notification(get_string('disablefieldswarning', 'tool_monitor'), 'notifyproblem');
    }
    $mform->display();
    echo $OUTPUT->footer();
    exit;
}

echo $OUTPUT->header();
if (!empty($ruleid)) {
    echo $OUTPUT->heading(get_string('editrule', 'tool_monitor'));
} else {
    echo $OUTPUT->heading(get_string('addrule', 'tool_monitor'));
}
$mform->set_data($rule);
$mform->display();
echo $OUTPUT->footer();
