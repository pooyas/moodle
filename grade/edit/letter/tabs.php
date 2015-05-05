<?php

/**
 * Prints navigation tabs for viewing and editing grade letters
 *
 * @package   core
 * @subpackage grades
 * @copyright 2015 Pooya Saeedi
 * 
 */

    $row = $tabs = array();

    $row[] = new tabobject('lettersview',
                           $CFG->wwwroot.'/grade/edit/letter/index.php?id='.$COURSE->id,
                           get_string('letters', 'grades'));

    if (has_capability('lion/grade:manageletters', $context)) {
        $row[] = new tabobject('lettersedit',
                               $CFG->wwwroot.'/grade/edit/letter/edit.php?id='.$context->id,
                               get_string('edit'));
    }

    $tabs[] = $row;

    echo '<div class="letterdisplay">';
    print_tabs($tabs, $currenttab);
    echo '</div>';


