<?php

/**
 * This file contains the function for feedback_plugin abstract class
 *
 * @package   mod
 * @subpackage assign
 * @copyright 2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot.'/mod/assign/assignmentplugin.php');

/**
 * Abstract class for feedback_plugin inherited from assign_plugin abstract class.
 *
 */
abstract class assign_feedback_plugin extends assign_plugin {

    /**
     * Return subtype name of the plugin.
     *
     * @return string
     */
    public function get_subtype() {
        return 'assignfeedback';
    }

    /**
     * If this plugin adds to the gradebook comments field, it must specify the format
     * of the comment.
     *
     * (From weblib.php)
     * define('FORMAT_LION',   '0');   // Does all sorts of transformations and filtering
     * define('FORMAT_HTML',     '1');   // Plain HTML (with some tags stripped)
     * define('FORMAT_PLAIN',    '2');   // Plain text (even tags are printed in full)
     * define('FORMAT_WIKI',     '3');   // Wiki-formatted text
     * define('FORMAT_MARKDOWN', '4');   // Markdown-formatted
     *
     * Only one feedback plugin can push comments to the gradebook and that is chosen by the assignment
     * settings page.
     *
     * @param stdClass $grade The grade
     * @return int
     */
    public function format_for_gradebook(stdClass $grade) {
        return FORMAT_LION;
    }

    /**
     * If this plugin adds to the gradebook comments field, it must format the text
     * of the comment.
     *
     * Only one feedback plugin can push comments to the gradebook and that is chosen by the assignment
     * settings page.
     *
     * @param stdClass $grade The grade
     * @return string
     */
    public function text_for_gradebook(stdClass $grade) {
        return '';
    }

    /**
     * Override to indicate a plugin supports quickgrading.
     *
     * @return boolean - True if the plugin supports quickgrading
     */
    public function supports_quickgrading() {
        return false;
    }

    /**
     * Get quickgrading form elements as html.
     *
     * @param int $userid The user id in the table this quickgrading element relates to
     * @param mixed $grade grade or null - The grade data.
     *                     May be null if there are no grades for this user (yet)
     * @return mixed - A html string containing the html form elements required for
     *                 quickgrading or false to indicate this plugin does not support quickgrading
     */
    public function get_quickgrading_html($userid, $grade) {
        return false;
    }

    /**
     * Has the plugin quickgrading form element been modified in the current form submission?
     *
     * @param int $userid The user id in the table this quickgrading element relates to
     * @param stdClass $grade The grade
     * @return boolean - true if the quickgrading form element has been modified
     */
    public function is_quickgrading_modified($userid, $grade) {
        return false;
    }

    /**
     * Save quickgrading changes.
     *
     * @param int $userid The user id in the table this quickgrading element relates to
     * @param stdClass $grade The grade
     * @return boolean - true if the grade changes were saved correctly
     */
    public function save_quickgrading_changes($userid, $grade) {
        return false;
    }

    /**
     * Return a list of the batch grading operations supported by this plugin.
     *
     * @return array - An array of action and description strings.
     *                 The action will be passed to grading_batch_operation.
     */
    public function get_grading_batch_operations() {
        return array();
    }

    /**
     * Return a list of the grading actions supported by this plugin.
     *
     * A grading action is a page that is not specific to a user but to the whole assignment.
     * @return array - An array of action and description strings.
     *                 The action will be passed to grading_action.
     */
    public function get_grading_actions() {
        return array();
    }

    /**
     * Show a grading action form
     *
     * @param string $gradingaction The action chosen from the grading actions menu
     * @return string The page containing the form
     */
    public function grading_action($gradingaction) {
        return '';
    }

    /**
     * Show a batch operations form
     *
     * @param string $action The action chosen from the batch operations menu
     * @param array $users The list of selected userids
     * @return string The page containing the form
     */
    public function grading_batch_operation($action, $users) {
        return '';
    }
}
