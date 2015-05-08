<?php

/**
 * Atto text editor align plugin lib.
 *
 * @package    atto
 * @subpackage align
 * @copyright  2015 Pooya Saeedi
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
