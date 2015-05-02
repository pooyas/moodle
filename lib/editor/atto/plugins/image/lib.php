<?php

/**
 * Atto text editor integration version file.
 *
 * @package    atto_image
 * @copyright  2013 Damyon Wiese  <damyon@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Initialise the strings required for js
 */
function atto_image_strings_for_js() {
    global $PAGE;

    $strings = array(
        'alignment',
        'alignment_bottom',
        'alignment_left',
        'alignment_middle',
        'alignment_right',
        'alignment_top',
        'browserepositories',
        'constrain',
        'saveimage',
        'imageproperties',
        'customstyle',
        'enterurl',
        'enteralt',
        'height',
        'presentation',
        'presentationoraltrequired',
        'size',
        'width',
        'uploading',
    );

    $PAGE->requires->strings_for_js($strings, 'atto_image');
}

