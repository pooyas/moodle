<?php

/**
 * Atto upgrade script.
 *
 * @package    editor
 * @subpackage atto
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Make the Atto the default editor for upgrades from 26.
 *
 * @return bool
 */
function xmldb_editor_atto_install() {
    global $CFG;

    // Make Atto the default.
    $currenteditors = $CFG->texteditors;
    $neweditors = array();

    $list = explode(',', $currenteditors);
    array_push($neweditors, 'atto');
    foreach ($list as $editor) {
        if ($editor != 'atto') {
            array_push($neweditors, $editor);
        }
    }

    set_config('texteditors', implode(',', $neweditors));

    return true;
}
