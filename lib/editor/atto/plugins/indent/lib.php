<?php

/**
 * Atto text editor align plugin lib.
 *
 * @package    atto_align
 * @copyright  2014 Jason Fowler
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Initialise the strings required for JS.
 *
 * @return void
 */
function atto_indent_strings_for_js() {
    global $PAGE;
    $PAGE->requires->strings_for_js(array('indent', 'outdent'), 'atto_indent');
}
