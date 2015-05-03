<?php

/**
 * Atto text editor integration version file.
 *
 * @package    atto_accessibilityhelper
 * @copyright  2015 Pooya Saeedi  <damyon@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Initialise this plugin
 * @param string $elementid
 */
function atto_accessibilityhelper_strings_for_js() {
    global $PAGE;

    $PAGE->requires->strings_for_js(array('liststyles',
                                    'nostyles',
                                    'listlinks',
                                    'nolinks',
                                    'selectlink',
                                    'listimages',
                                    'noimages',
                                    'selectimage'),
                                    'atto_accessibilityhelper');
}

