<?php

/**
 * Atto text editor integration version file.
 *
 * @package    atto_table
 * @copyright  2013 Damyon Wiese  <damyon@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Initialise the js strings required for this module.
 */
function atto_table_strings_for_js() {
    global $PAGE;

    $PAGE->requires->strings_for_js(array('createtable',
                                          'updatetable',
                                          'headers',
                                          'caption',
                                          'columns',
                                          'rows',
                                          'numberofcolumns',
                                          'numberofrows',
                                          'both',
                                          'edittable',
                                          'addcolumnafter',
                                          'addrowafter',
                                          'movecolumnright',
                                          'movecolumnleft',
                                          'moverowdown',
                                          'moverowup',
                                          'deleterow',
                                          'deletecolumn'),
                                    'atto_table');
}

