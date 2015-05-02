<?php

/**
 * Atto text editor align plugin lib.
 *
 * @package    atto_align
 * @copyright  2014 Frédéric Massart
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Initialise the strings required for JS.
 *
 * @return void
 */
function atto_align_strings_for_js() {
    global $PAGE;
    $PAGE->requires->strings_for_js(array('center', 'leftalign', 'rightalign'), 'atto_align');
}
