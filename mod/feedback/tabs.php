<?php

/**
 * prints the tabbed bar
 *
 * @package    mod
 * @subpackage feedback
 * @copyright  2015 Pooya Saeedi
 */
defined('LION_INTERNAL') OR die('not allowed');

$tabs = array();
$row  = array();
$inactive = array();
$activated = array();

//some pages deliver the cmid instead the id
if (isset($cmid) AND intval($cmid) AND $cmid > 0) {
    $usedid = $cmid;
} else {
    $usedid = $id;
}

$context = context_module::instance($usedid);

$courseid = optional_param('courseid', false, PARAM_INT);
// $current_tab = $SESSION->feedback->current_tab;
if (!isset($current_tab)) {
    $current_tab = '';
}

$viewurl = new lion_url('/mod/feedback/view.php', array('id'=>$usedid, 'do_show'=>'view'));
$row[] = new tabobject('view', $viewurl->out(), get_string('overview', 'feedback'));

if (has_capability('mod/feedback:edititems', $context)) {
    $editurl = new lion_url('/mod/feedback/edit.php', array('id'=>$usedid, 'do_show'=>'edit'));
    $row[] = new tabobject('edit', $editurl->out(), get_string('edit_items', 'feedback'));

    $templateurl = new lion_url('/mod/feedback/edit.php', array('id'=>$usedid, 'do_show'=>'templates'));
    $row[] = new tabobject('templates', $templateurl->out(), get_string('templates', 'feedback'));
}

if (has_capability('mod/feedback:viewreports', $context)) {
    if ($feedback->course == SITEID) {
        $url_params = array('id'=>$usedid, 'courseid'=>$courseid, 'do_show'=>'analysis');
        $analysisurl = new lion_url('/mod/feedback/analysis_course.php', $url_params);
        $row[] = new tabobject('analysis',
                                $analysisurl->out(),
                                get_string('analysis', 'feedback'));

    } else {
        $url_params = array('id'=>$usedid, 'courseid'=>$courseid, 'do_show'=>'analysis');
        $analysisurl = new lion_url('/mod/feedback/analysis.php', $url_params);
        $row[] = new tabobject('analysis',
                                $analysisurl->out(),
                                get_string('analysis', 'feedback'));
    }

    $url_params = array('id'=>$usedid, 'do_show'=>'showentries');
    $reporturl = new lion_url('/mod/feedback/show_entries.php', $url_params);
    $row[] = new tabobject('showentries',
                            $reporturl->out(),
                            get_string('show_entries', 'feedback'));

    if ($feedback->anonymous == FEEDBACK_ANONYMOUS_NO AND $feedback->course != SITEID) {
        $nonrespondenturl = new lion_url('/mod/feedback/show_nonrespondents.php', array('id'=>$usedid));
        $row[] = new tabobject('nonrespondents',
                                $nonrespondenturl->out(),
                                get_string('show_nonrespondents', 'feedback'));
    }
}

if (count($row) > 1) {
    $tabs[] = $row;

    print_tabs($tabs, $current_tab, $inactive, $activated);
}

