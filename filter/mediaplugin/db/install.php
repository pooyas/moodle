<?php

/**
 * Media filter post install hook
 *
 * @package    filter
 * @subpackage mediaplugin
 * @copyright  2015 Pooya Saeedi
 * 
 */

function xmldb_filter_mediaplugin_install() {
    global $CFG;
    require_once("$CFG->libdir/filterlib.php");

    filter_set_global_state('mediaplugin', TEXTFILTER_ON);
}

