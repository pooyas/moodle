<?php


/**
 * Atto text editor undo plugin lib.
 *
 * @package    editor
 * @subpackage atto
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Initialise the strings required for JS.
 *
 * @return void
 */
function atto_undo_strings_for_js() {
    global $PAGE;

    // In order to prevent extra strings to be imported, comment/uncomment the characters
    // which are enabled in the JavaScript part of this plugin.
    $PAGE->requires->strings_for_js(
        array(
            'redo',
            'undo'
        ),
        'atto_undo'
    );
}
