<?php

/**
 * Returns an array of reports to which are currently readable.
 * @package    mod
 * @subpackage scorm
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/* Generates and returns list of available Scorm report sub-plugins
 *
 * @param context context level to check caps against
 * @return array list of valid reports present
 */
function scorm_report_list($context) {
    global $CFG;
    static $reportlist;
    if (!empty($reportlist)) {
        return $reportlist;
    }
    $installed = core_component::get_plugin_list('scormreport');
    foreach ($installed as $reportname => $notused) {

        // Lion 2.8+ style of autoloaded classes.
        $classname = "scormreport_$reportname\\report";
        if (class_exists($classname)) {
            $report = new $classname();

            if ($report->canview($context)) {
                $reportlist[] = $reportname;
            }
            continue;
        }

        // Legacy style of naming classes.
        $pluginfile = $CFG->dirroot.'/mod/scorm/report/'.$reportname.'/report.php';
        if (is_readable($pluginfile)) {
            debugging("Please use autoloaded classnames for your plugin. Refer MDL-46469 for details", DEBUG_DEVELOPER);
            include_once($pluginfile);
            $reportclassname = "scorm_{$reportname}_report";
            if (class_exists($reportclassname)) {
                $report = new $reportclassname();

                if ($report->canview($context)) {
                    $reportlist[] = $reportname;
                }
            }
        }
    }
    return $reportlist;
}
/**
 * Returns The maximum numbers of Questions associated with an Scorm Pack
 *
 * @param int Scorm ID
 * @return int an integer representing the question count
 */
function get_scorm_question_count($scormid) {
    global $DB;
    $count = 0;
    $params = array();
    $select = "scormid = ? AND ";
    $select .= $DB->sql_like("element", "?", false);
    $params[] = $scormid;
    $params[] = "cmi.interactions_%.id";
    $rs = $DB->get_recordset_select("scorm_scoes_track", $select, $params, 'element');
    $keywords = array("cmi.interactions_", ".id");
    if ($rs->valid()) {
        foreach ($rs as $record) {
            $num = trim(str_ireplace($keywords, '', $record->element));
            if (is_numeric($num) && $num > $count) {
                $count = $num;
            }
        }
        // Done as interactions start at 0 (do only if we have something to report).
        $count++;
    }
    $rs->close(); // Closing recordset.
    return $count;
}
