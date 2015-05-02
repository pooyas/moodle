<?php

/**
 * Post-install script for the quiz statistics report.
 *
 * @package   quiz_statistics
 * @copyright 2008 Jamie Pratt
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Quiz statistics report upgrade code.
 */
function xmldb_quiz_statistics_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    // Lion v2.2.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.3.0 release upgrade line
    // Put any upgrade step following this

    // Lion v2.4.0 release upgrade line
    // Put any upgrade step following this

    // Lion v2.5.0 release upgrade line.
    // Put any upgrade step following this.

    if ($oldversion < 2013092000) {

        // Define table question_statistics to be dropped.
        $table = new xmldb_table('quiz_question_statistics');

        // Conditionally launch drop table for question_statistics.
        if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }

        // Define table question_response_analysis to be dropped.
        $table = new xmldb_table('quiz_question_response_stats');

        // Conditionally launch drop table for question_response_analysis.
        if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }

        $table = new xmldb_table('quiz_statistics');
        $field = new xmldb_field('quizid');

        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        $field = new xmldb_field('groupid');

        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        $field = new xmldb_field('hashcode', XMLDB_TYPE_CHAR, '40', null, XMLDB_NOTNULL, null, null, 'id');

        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Main savepoint reached.
        upgrade_plugin_savepoint(true, 2013092000, 'quiz', 'statistics');
    }

    if ($oldversion < 2013093000) {
        // Define table quiz_statistics to be dropped.
        $table = new xmldb_table('quiz_statistics');

        // Conditionally launch drop table for quiz_statistics.
        if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }

        // Define table quiz_statistics to be created.
        $table = new xmldb_table('quiz_statistics');

        // Adding fields to table quiz_statistics.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('hashcode', XMLDB_TYPE_CHAR, '40', null, XMLDB_NOTNULL, null, null);
        $table->add_field('whichattempts', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('firstattemptscount', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('highestattemptscount', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('lastattemptscount', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('allattemptscount', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('firstattemptsavg', XMLDB_TYPE_NUMBER, '15, 5', null, null, null, null);
        $table->add_field('highestattemptsavg', XMLDB_TYPE_NUMBER, '15, 5', null, null, null, null);
        $table->add_field('lastattemptsavg', XMLDB_TYPE_NUMBER, '15, 5', null, null, null, null);
        $table->add_field('allattemptsavg', XMLDB_TYPE_NUMBER, '15, 5', null, null, null, null);
        $table->add_field('median', XMLDB_TYPE_NUMBER, '15, 5', null, null, null, null);
        $table->add_field('standarddeviation', XMLDB_TYPE_NUMBER, '15, 5', null, null, null, null);
        $table->add_field('skewness', XMLDB_TYPE_NUMBER, '15, 10', null, null, null, null);
        $table->add_field('kurtosis', XMLDB_TYPE_NUMBER, '15, 5', null, null, null, null);
        $table->add_field('cic', XMLDB_TYPE_NUMBER, '15, 10', null, null, null, null);
        $table->add_field('errorratio', XMLDB_TYPE_NUMBER, '15, 10', null, null, null, null);
        $table->add_field('standarderror', XMLDB_TYPE_NUMBER, '15, 10', null, null, null, null);

        // Adding keys to table quiz_statistics.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for quiz_statistics.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Statistics savepoint reached.
        upgrade_plugin_savepoint(true, 2013093000, 'quiz', 'statistics');
    }

    // Lion v2.6.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.7.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}

