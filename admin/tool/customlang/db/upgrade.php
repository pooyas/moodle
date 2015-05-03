<?php


/**
 * Language customization report upgrades
 *
 * @package    tool
 * @subpackage customlang
 * @copyright  2015 Pooya Saeedi
 * 
 */

function xmldb_tool_customlang_upgrade($oldversion) {
    global $CFG, $DB, $OUTPUT;

    $dbman = $DB->get_manager();

    return true;
}
