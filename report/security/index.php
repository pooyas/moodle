<?php

/**
 * Security overview report
 *
 * @package    report
 * @subpackage security
 * @copyright  2015 Pooya Saeedi
 * 
 */

define('NO_OUTPUT_BUFFERING', true);

require('../../config.php');
require_once($CFG->dirroot.'/report/security/locallib.php');
require_once($CFG->libdir.'/adminlib.php');

require_login();

$issue = optional_param('issue', '', PARAM_ALPHANUMEXT); // show detailed info about one issue only

$issues = report_security_get_issue_list();

// test if issue valid string
if (array_search($issue, $issues, true) === false) {
    $issue = '';
}

// we may need a bit more memory and this may take a long time to process
raise_memory_limit(MEMORY_EXTRA);
core_php_time_limit::raise();

// Print the header.
admin_externalpage_setup('reportsecurity', '', null, '', array('pagelayout'=>'report'));
echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('pluginname', 'report_security'));

echo '<div id="timewarning">'.get_string('timewarning', 'report_security').'</div>';

$strok       = '<span class="statusok">'.get_string('statusok', 'report_security').'</span>';
$strinfo     = '<span class="statusinfo">'.get_string('statusinfo', 'report_security').'</span>';
$strwarning  = '<span class="statuswarning">'.get_string('statuswarning', 'report_security').'</span>';
$strserious  = '<span class="statusserious">'.get_string('statusserious', 'report_security').'</span>';
$strcritical = '<span class="statuscritical">'.get_string('statuscritical', 'report_security').'</span>';

$strissue    = get_string('issue', 'report_security');
$strstatus   = get_string('status', 'report_security');
$strdesc     = get_string('description', 'report_security');
$strconfig   = get_string('configuration', 'report_security');

$statusarr = array(REPORT_SECURITY_OK       => $strok,
                   REPORT_SECURITY_INFO     => $strinfo,
                   REPORT_SECURITY_WARNING  => $strwarning,
                   REPORT_SECURITY_SERIOUS  => $strserious,
                   REPORT_SECURITY_CRITICAL => $strcritical);

$url = "$CFG->wwwroot/report/security/index.php";

if ($issue and ($result = $issue(true))) {
    report_security_hide_timearning();

    $table = new html_table();
    $table->head  = array($strissue, $strstatus, $strdesc, $strconfig);
    $table->rowclasses = array('leftalign issue', 'leftalign status', 'leftalign desc', 'leftalign config');
    $table->attributes = array('class'=>'admintable securityreport generaltable');
    $table->id = 'securityissuereporttable';
    $table->data  = array();

    // print detail of one issue only
    $row = array();
    $row[0] = report_security_doc_link($issue, $result->name);
    $row[1] = $statusarr[$result->status];
    $row[2] = $result->info;
    $row[3] = is_null($result->link) ? '&nbsp;' : $result->link;

    $PAGE->set_docs_path('report/security/' . $issue);

    $table->data[] = $row;

    echo html_writer::table($table);

    echo $OUTPUT->box($result->details, 'generalbox boxwidthnormal boxaligncenter'); // TODO: add proper css

    echo $OUTPUT->continue_button($url);

} else {
    report_security_hide_timearning();

    $table = new html_table();
    $table->head  = array($strissue, $strstatus, $strdesc);
    $table->colclasses = array('leftalign issue', 'leftalign status', 'leftalign desc');
    $table->attributes = array('class'=>'admintable securityreport generaltable');
    $table->id = 'securityreporttable';
    $table->data  = array();

    foreach ($issues as $issue) {
        $result = $issue(false);
        if (!$result) {
            // ignore this test
            continue;
        }
        $row = array();
        $row[0] = "<a href='$url?issue=$result->issue'>$result->name</a>";
        $row[1] = $statusarr[$result->status];
        $row[2] = $result->info;

        $table->data[] = $row;
    }
    echo html_writer::table($table);
}

echo $OUTPUT->footer();
