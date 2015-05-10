<?php

/**
 * Performance overview report
 *
 * @package   report
 * @subpackage performance
 * @copyright 2015 Pooya Saeedi
 * 
 */

define('NO_OUTPUT_BUFFERING', true);

require('../../config.php');
require_once($CFG->dirroot.'/report/performance/locallib.php');
require_once($CFG->libdir.'/adminlib.php');

require_login();

// Show detailed info about one issue only.
$issue = optional_param('issue', '', PARAM_ALPHANUMEXT);

$reportperformance = new report_performance();
$issues = $reportperformance->get_issue_list();

// Test if issue valid string.
if (array_search($issue, $issues, true) === false) {
    $issue = '';
}

// Print the header.
admin_externalpage_setup('reportperformance', '', null, '', array('pagelayout'=>'report'));
echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('pluginname', 'report_performance'));

$strissue = get_string('issue', 'report_performance');
$strvalue = get_string('value', 'report_performance');
$strcomments = get_string('comments', 'report_performance');
$stredit = get_string('edit');

$table = new html_table();
$table->head  = array($strissue, $strvalue, $strcomments, $stredit);
$table->colclasses = array('mdl-left issue', 'mdl-left value', 'mdl-left comments', 'mdl-left config');
$table->attributes = array('class' => 'admintable performancereport generaltable');
$table->id = 'performanceissuereporttable';
$table->data  = array();

// Print details of one issue only.
if ($issue and ($issueresult = $reportperformance::$issue())) {
    $reportperformance->add_issue_to_table($table, $issueresult, true);

    $PAGE->set_docs_path('report/security/' . $issue);

    echo html_writer::table($table);

    echo $OUTPUT->box($issueresult->details, 'generalbox boxwidthnormal boxaligncenter');

    echo $OUTPUT->continue_button(new lion_url('/report/performance/index.php'));
} else {
    // Add Performance report description on main list page.
    $morehelplink = $OUTPUT->doc_link('report/performance', get_string('morehelp', 'report_performance'));
    echo $OUTPUT->box(get_string('performancereportdesc', 'report_performance', $morehelplink), 'generalbox mdl-align');

    foreach ($issues as $issue) {
        $issueresult = $reportperformance::$issue();
        if (!$issueresult) {
            // Ignore this test.
            continue;
        }
        $reportperformance->add_issue_to_table($table, $issueresult, false);
    }
    echo html_writer::table($table);
}

echo $OUTPUT->footer();
