<?php

/**
 * Prints navigation tabs
 *
 * @package    core
 * @subpackage group
 * @copyright  2015 Pooya Saeedi
 * 
 */
    $row = array();
    $row[] = new tabobject('groups',
                           new lion_url('/group/index.php', array('id' => $courseid)),
                           get_string('groups'));

    $row[] = new tabobject('groupings',
                           new lion_url('/group/groupings.php', array('id' => $courseid)),
                           get_string('groupings', 'group'));

    $row[] = new tabobject('overview',
                           new lion_url('/group/overview.php', array('id' => $courseid)),
                           get_string('overview', 'group'));
    echo '<div class="groupdisplay">';
    echo $OUTPUT->tabtree($row, $currenttab);
    echo '</div>';
