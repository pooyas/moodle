<?php

/**
 * Outputs navigation tabs for the grader report
 *
 * @package   gradereport_grader
 * @copyright 2007 2015 Pooya Saeedi
 * 
 */

    $row = $tabs = array();
    $tabcontext = context_course::instance($COURSE->id);
    $row[] = new tabobject('graderreport',
                           $CFG->wwwroot.'/grade/report/grader/index.php?id='.$courseid,
                           get_string('pluginname', 'gradereport_grader'));
    if (has_capability('lion/grade:manage',$tabcontext ) ||
        has_capability('lion/grade:edit', $tabcontext) ||
        has_capability('gradereport/grader:view', $tabcontext)) {
        $row[] = new tabobject('preferences',
                               $CFG->wwwroot.'/grade/report/grader/preferences.php?id='.$courseid,
                               get_string('myreportpreferences', 'grades'));
    }

    $tabs[] = $row;
    echo '<div class="gradedisplay">';
    print_tabs($tabs, $currenttab);
    echo '</div>';

