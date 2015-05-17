<?php


/**
 * Atto text editor integration version file.
 *
 * @package    editor
 * @subpackage atto
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Initialise this plugin
 * @param string $elementid
 */
function atto_link_strings_for_js() {
    global $PAGE;

    $PAGE->requires->strings_for_js(array('createlink',
                                          'unlink',
                                          'enterurl',
                                          'browserepositories',
                                          'openinnewwindow'),
                                    'atto_link');
}

