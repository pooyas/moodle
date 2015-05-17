<?php


/**
 * Atto upgrade script.
 *
 * @package    editor
 * @subpackage atto
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Run all Atto upgrade steps between the current DB version and the current version on disk.
 * @param int $oldversion The old version of atto in the DB.
 * @return bool
 */
function xmldb_editor_atto_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2014032800) {
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
        upgrade_plugin_savepoint(true, 2014032800, 'editor', 'atto');
    }

    // Lion v2.7.0 release upgrade line.
    // Put any upgrade step following this.
    if ($oldversion < 2014081400) {

        // Define table editor_atto_autosave to be created.
        $table = new xmldb_table('editor_atto_autosave');

        // Adding fields to table editor_atto_autosave.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('elementid', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('contextid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('pagehash', XMLDB_TYPE_CHAR, '64', null, XMLDB_NOTNULL, null, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('drafttext', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('draftid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('pageinstance', XMLDB_TYPE_CHAR, '64', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table editor_atto_autosave.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('autosave_uniq_key', XMLDB_KEY_UNIQUE, array('elementid', 'contextid', 'userid', 'pagehash'));

        // Conditionally launch create table for editor_atto_autosave.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Atto savepoint reached.
        upgrade_plugin_savepoint(true, 2014081400, 'editor', 'atto');
    }

    if ($oldversion < 2014081900) {

        // Define field timemodified to be added to editor_atto_autosave.
        $table = new xmldb_table('editor_atto_autosave');
        $field = new xmldb_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'pageinstance');

        // Conditionally launch add field timemodified.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Atto savepoint reached.
        upgrade_plugin_savepoint(true, 2014081900, 'editor', 'atto');
    }

    // Lion v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
