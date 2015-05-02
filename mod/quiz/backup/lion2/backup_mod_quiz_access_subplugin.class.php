<?php

/**
 * Defines the base class for quiz access plugins backup code.
 *
 * @package   mod_quiz
 * @copyright 2011 The Open University
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Base class for backing up all the quiz settings and attempt data for an
 * access rule quiz sub-plugin.
 *
 * @copyright  2011 The Open University
 * 
 */
class backup_mod_quiz_access_subplugin extends backup_subplugin {

    /**
     * Use this method to describe the XML structure required to store your
     * sub-plugin's settings for a particular quiz, and how that data is stored
     * in the database.
     */
    protected function define_quiz_subplugin_structure() {
        // Do nothing by default.
    }

    /**
     * Use this method to describe the XML structure required to store your
     * sub-plugin's settings for a particular quiz attempt, and how that data
     * is stored in the database.
     */
    protected function define_attempt_subplugin_structure() {
        // Do nothing by default.
    }
}
