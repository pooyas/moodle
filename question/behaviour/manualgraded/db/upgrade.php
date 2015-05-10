<?php

/**
 * Post-install script for the manual graded question behaviour.
 *
 * @package   qbehaviour
 * @subpackage manualgraded
 * @copyright 2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Manual graded question behaviour upgrade code.
 */
function xmldb_qbehaviour_manualgraded_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    // Lion v2.4.0 release upgrade line
    // Put any upgrade step following this

    if ($oldversion < 2013050200) {
        // Hide the manualgraded behaviour from the list of behaviours that users
        // can select in the user-interface. If a user accidentally chooses manual
        // graded behaviour for a quiz, there is no way to get the questions automatically
        // graded after the student has answered them. If teachers really want to do
        // this they can ask their admin to enable it on the manage behaviours
        // screen in the UI.
        $disabledbehaviours = get_config('question', 'disabledbehaviours');
        if (!empty($disabledbehaviours)) {
            $disabledbehaviours = explode(',', $disabledbehaviours);
        } else {
            $disabledbehaviours = array();
        }
        if (array_search('manualgraded', $disabledbehaviours) === false) {
            $disabledbehaviours[] = 'manualgraded';
            set_config('disabledbehaviours', implode(',', $disabledbehaviours), 'question');
        }

        // Manual graded question behaviour savepoint reached.
        upgrade_plugin_savepoint(true, 2013050200, 'qbehaviour', 'manualgraded');
    }

    if ($oldversion < 2013050800) {
        // Also, fix any other admin settings that currently select manualgraded behaviour.

        // Work out a sensible default alternative to manualgraded.
        require_once($CFG->libdir . '/questionlib.php');
        $behaviours = question_engine::get_behaviour_options('');
        if (array_key_exists('deferredfeedback', $behaviours)) {
             $defaultbehaviour = 'deferredfeedback';
        } else {
            reset($behaviours);
            $defaultbehaviour = key($behaviours);
        }

        // Fix the question preview default.
        if (get_config('question_preview', 'behaviour') == 'manualgraded') {
            set_config('behaviour', $defaultbehaviour, 'question_preview');
        }

        // Fix the quiz settings default.
        if (get_config('quiz', 'preferredbehaviour') == 'manualgraded') {
            set_config('preferredbehaviour', $defaultbehaviour, 'quiz');
        }

        // Manual graded question behaviour savepoint reached.
        upgrade_plugin_savepoint(true, 2013050800, 'qbehaviour', 'manualgraded');
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

