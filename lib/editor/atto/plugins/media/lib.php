<?php

/**
 * Atto text editor integration version file.
 *
 * @package    atto_media
 * @copyright  2013 Damyon Wiese  <damyon@lion.com>
 * 
 */

/**
 * Initialise the js strings required for this plugin
 */
function atto_media_strings_for_js() {
    global $PAGE;

    $PAGE->requires->strings_for_js(array('createmedia',
                                          'enterurl',
                                          'entername',
                                          'browserepositories'),
                                    'atto_media');
}
