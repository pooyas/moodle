<?php

/**
 * Filter post install hook
 *
 * @package    filter_activitynames
 * @copyright  2015 Pooya Saeedi 
 * 
 */

function xmldb_filter_activitynames_install() {
    global $CFG;
    require_once("$CFG->libdir/filterlib.php");

    filter_set_global_state('activitynames', TEXTFILTER_ON, 1);
}

