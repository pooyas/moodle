<?php

/**
 * Mathjax filter post install hook
 *
 * @package    filter
 * @subpackage mathjaxloader
 * @copyright  2014 onwards Andrew Davis (andyjdavis)
 * 
 */

defined('LION_INTERNAL') || die();

function xmldb_filter_mathjaxloader_install() {
    global $CFG;
    require_once("$CFG->libdir/filterlib.php");

    filter_set_global_state('mathjaxloader', TEXTFILTER_ON, -1);
}
