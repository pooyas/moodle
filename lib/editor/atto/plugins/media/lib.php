<?php

/**
 * Atto text editor integration version file.
 *
 * @package    atto
 * @subpackage media
 * @copyright  2015 Pooya Saeedi  
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
