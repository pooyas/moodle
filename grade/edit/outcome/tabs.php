<?php


/**
 * Prints navigation tabs for viewing and editing grade outcomes
 *
 * @package    grade
 * @subpackage edit
 * @copyright  2015 Pooya Saeedi
 */

    $row = $tabs = array();

    $context = context_course::instance($courseid);

    $row[] = new tabobject('courseoutcomes',
                           $CFG->wwwroot.'/grade/edit/outcome/course.php?id='.$courseid,
                           get_string('outcomescourse', 'grades'));

    if (has_capability('lion/grade:manage', $context)) {
        $row[] = new tabobject('outcomes',
                               $CFG->wwwroot.'/grade/edit/outcome/index.php?id='.$courseid,
                               get_string('editoutcomes', 'grades'));
    }

    $tabs[] = $row;

    echo '<div class="outcomedisplay">';
    print_tabs($tabs, $currenttab);
    echo '</div>';


