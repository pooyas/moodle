<?php


/**
 * Short-answer question type upgrade code.
 *
 * @package    question_type
 * @subpackage shortanswer
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();


/**
 * Upgrade code for the essay question type.
 * @param int $oldversion the version we are upgrading from.
 */
function xmldb_qtype_shortanswer_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    // Lion v2.4.0 release upgrade line.
    // Put any upgrade step following this.

    if ($oldversion < 2013011799) {
        // Find duplicate rows before they break the 2013011803 step below.
        $problemids = $DB->get_recordset_sql("
                SELECT question, MIN(id) AS recordidtokeep
                  FROM {question_shortanswer}
              GROUP BY question
                HAVING COUNT(1) > 1
                ");
        foreach ($problemids as $problem) {
            $DB->delete_records_select('question_shortanswer',
                    'question = ? AND id > ?',
                    array($problem->question, $problem->recordidtokeep));
        }
        $problemids->close();

        // Shortanswer savepoint reached.
        upgrade_plugin_savepoint(true, 2013011799, 'qtype', 'shortanswer');
    }

    if ($oldversion < 2013011800) {

        // Define field answers to be dropped from question_shortanswer.
        $table = new xmldb_table('question_shortanswer');
        $field = new xmldb_field('answers');

        // Conditionally launch drop field answers.
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        // Shortanswer savepoint reached.
        upgrade_plugin_savepoint(true, 2013011800, 'qtype', 'shortanswer');
    }

    if ($oldversion < 2013011801) {

        // Define key question (foreign) to be dropped form question_shortanswer.
        $table = new xmldb_table('question_shortanswer');
        $key = new xmldb_key('question', XMLDB_KEY_FOREIGN, array('question'), 'question', array('id'));

        // Launch drop key question.
        $dbman->drop_key($table, $key);

        // Shortanswer savepoint reached.
        upgrade_plugin_savepoint(true, 2013011801, 'qtype', 'shortanswer');
    }

    if ($oldversion < 2013011802) {

        // Rename field question on table question_shortanswer to questionid.
        $table = new xmldb_table('question_shortanswer');
        $field = new xmldb_field('question', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'id');

        // Launch rename field question.
        $dbman->rename_field($table, $field, 'questionid');

        // Shortanswer savepoint reached.
        upgrade_plugin_savepoint(true, 2013011802, 'qtype', 'shortanswer');
    }

    if ($oldversion < 2013011803) {

        // Define key questionid (foreign-unique) to be added to question_shortanswer.
        $table = new xmldb_table('question_shortanswer');
        $key = new xmldb_key('questionid', XMLDB_KEY_FOREIGN_UNIQUE, array('questionid'), 'question', array('id'));

        // Launch add key questionid.
        $dbman->add_key($table, $key);

        // Shortanswer savepoint reached.
        upgrade_plugin_savepoint(true, 2013011803, 'qtype', 'shortanswer');
    }

    if ($oldversion < 2013011804) {

        // Define table qtype_shortanswer_options to be renamed to qtype_shortanswer_options.
        $table = new xmldb_table('question_shortanswer');

        // Launch rename table for qtype_shortanswer_options.
        $dbman->rename_table($table, 'qtype_shortanswer_options');

        // Shortanswer savepoint reached.
        upgrade_plugin_savepoint(true, 2013011804, 'qtype', 'shortanswer');
    }

    // Lion v2.5.0 release upgrade line.
    // Put any upgrade step following this.


    // Lion v2.6.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.7.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
