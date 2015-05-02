<?php
/**
 * Core Report class of graphs reporting plugin
 *
 * @package    scormreport_graphs
 * @copyright  2012 Ankit Kumar Agarwal
 * 
 */

namespace scormreport_graphs;

defined('LION_INTERNAL') || die();
/**
 * Main class to control the graphs reporting
 *
 * @package    scormreport_graphs
 * @copyright  2012 Ankit Kumar Agarwal
 * 
 */

class report extends \mod_scorm\report {
    /**
     * Displays the full report
     *
     * @param \stdClass $scorm full SCORM object
     * @param \stdClass $cm - full course_module object
     * @param \stdClass $course - full course object
     * @param string $download - type of download being requested
     */
    public function display($scorm, $cm, $course, $download) {
        global $DB, $OUTPUT, $PAGE;

        if ($groupmode = groups_get_activity_groupmode($cm)) {   // Groups are being used.
            groups_print_activity_menu($cm, new \lion_url($PAGE->url));
        }

        if ($scoes = $DB->get_records('scorm_scoes', array("scorm" => $scorm->id), 'sortorder, id')) {
            foreach ($scoes as $sco) {
                if ($sco->launch != '') {
                    $imageurl = new \lion_url('/mod/scorm/report/graphs/graph.php',
                            array('scoid' => $sco->id));
                    $graphname = $sco->title;
                    echo $OUTPUT->heading($graphname, 3);
                    echo \html_writer::tag('div', \html_writer::empty_tag('img',
                            array('src' => $imageurl, 'alt' => $graphname)),
                            array('class' => 'graph'));
                }
            }
        }
    }
}
