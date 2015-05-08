<?php

/**
 * Atto text editor integration version file.
 *
 * @package    atto
 * @subpackage accessibilitychecker
 * @copyright  2015 Pooya Saeedi  
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Initialise this plugin
 * @param string $elementid
 */
function atto_accessibilitychecker_strings_for_js() {
    global $PAGE;

    $PAGE->requires->strings_for_js(array('nowarnings',
                                    'report',
                                    'imagesmissingalt',
                                    'needsmorecontrast',
                                    'needsmoreheadings',
                                    'tableswithmergedcells',
                                    'tablesmissingcaption',
                                    'emptytext',
                                    'entiredocument',
                                    'tablesmissingheaders'),
                                    'atto_accessibilitychecker');
}

