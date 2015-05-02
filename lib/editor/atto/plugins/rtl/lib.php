<?php

/**
 * Atto text editor rtl plugin lib.
 *
 * @package    atto_rtl
 * @copyright  2014 Jerome Mouneyrac
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Initialise the strings required for JS.
 *
 * @return void
 */
function atto_rtl_strings_for_js() {
    global $PAGE;

    // In order to prevent extra strings to be imported, comment/uncomment the characters
    // which are enabled in the JavaScript part of this plugin.
    $PAGE->requires->strings_for_js(
        array(
            'rtl',
            'ltr'
        ),
        'atto_rtl'
    );
}
