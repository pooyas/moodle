<?php


/**
 * Displays live view of recent logs
 *
 * This file generates live view of recent logs.
 *
 * @package    report
 * @subpackage loglive
 * @copyright  2015 Pooya Saeedi
 */

require('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot.'/course/lib.php');

$id = optional_param('id', 0, PARAM_INT);
$page = optional_param('page', 0, PARAM_INT);
$logreader = optional_param('logreader', '', PARAM_COMPONENT); // Reader which will be used for displaying logs.

if (empty($id)) {
    require_login();
    $context = context_system::instance();
    $coursename = format_string($SITE->fullname, true, array('context' => $context));
} else {
    $course = get_course($id);
    require_login($course);
    $context = context_course::instance($course->id);
    $coursename = format_string($course->fullname, true, array('context' => $context));
}
require_capability('report/loglive:view', $context);

$params = array();
if ($id != 0) {
    $params['id'] = $id;
}
if ($page != 0) {
    $params['page'] = $page;
}
if ($logreader !== '') {
    $params['logreader'] = $logreader;
}
$url = new lion_url("/report/loglive/index.php", $params);

$PAGE->set_url($url);
$PAGE->set_pagelayout('report');

$renderable = new report_loglive_renderable($logreader, $id, $url, 0, $page);
$refresh = $renderable->get_refresh_rate();
$logreader = $renderable->selectedlogreader;

// Include and trigger ajax requests.
if ($page == 0 && !empty($logreader)) {
    // Tell Js to fetch new logs only, by passing time().
    $jsparams = array('since' => time() , 'courseid' => $id, 'page' => $page, 'logreader' => $logreader,
            'interval' => $refresh, 'perpage' => $renderable->perpage);
    $PAGE->requires->strings_for_js(array('pause', 'resume'), 'report_loglive');
    $PAGE->requires->yui_module('lion-report_loglive-fetchlogs', 'Y.M.report_loglive.FetchLogs.init', array($jsparams));
}

$strlivelogs = get_string('livelogs', 'report_loglive');
$strupdatesevery = get_string('updatesevery', 'lion', $refresh);

if (empty($id)) {
    admin_externalpage_setup('reportloglive', '', null, '', array('pagelayout' => 'report'));
}
$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_title("$coursename: $strlivelogs ($strupdatesevery)");
$PAGE->set_heading("$coursename: $strlivelogs ($strupdatesevery)");

$output = $PAGE->get_renderer('report_loglive');
echo $output->header();
echo $output->reader_selector($renderable);
echo $output->toggle_liveupdate_button($renderable);
echo $output->render($renderable);

// Trigger a logs viewed event.
$event = \report_loglive\event\report_viewed::create(array('context' => $context));
$event->trigger();

echo $output->footer();