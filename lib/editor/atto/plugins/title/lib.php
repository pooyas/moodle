<?php


/**
 * Atto text editor integration version file.
 *
 * @package    editor
 * @subpackage atto
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

function atto_title_strings_for_js() {
    global $PAGE;

    $PAGE->requires->strings_for_js(array('h3',
                                          'h4',
                                          'h5',
                                          'pre',
                                          'p'), 'atto_title');
}

