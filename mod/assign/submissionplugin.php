<?php


/**
 * This file contains the definition for the abstract class for submission_plugin
 *
 * This class provides all the functionality for submission plugins.
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/assign/assignmentplugin.php');

/**
 * Abstract base class for submission plugin types.
 *
 */
abstract class assign_submission_plugin extends assign_plugin {

    /**
     * return subtype name of the plugin
     *
     * @return string
     */
    public final function get_subtype() {
        return 'assignsubmission';
    }

    /**
     * This plugin accepts submissions from a student
     * The comments plugin has no submission component so should not be counted
     * when determining whether to show the edit submission link.
     * @return boolean
     */
    public function allow_submissions() {
        return true;
    }


    /**
     * Check if the submission plugin has all the required data to allow the work
     * to be submitted for grading
     * @param stdClass $submission the assign_submission record being submitted.
     * @return bool|string 'true' if OK to proceed with submission, otherwise a
     *                        a message to display to the user
     */
    public function precheck_submission($submission) {
        return true;
    }

    /**
     * Carry out any extra processing required when the work is submitted for grading
     * @param stdClass $submission the assign_submission record being submitted.
     * @return void
     */
    public function submit_for_grading($submission) {
    }

    /**
     * Copy the plugin specific submission data to a new submission record.
     *
     * @param stdClass $oldsubmission - Old submission record
     * @param stdClass $submission - New submission record
     * @return bool
     */
    public function copy_submission( stdClass $oldsubmission, stdClass $submission) {
        return true;
    }

    /**
     * Carry out any extra processing required when the work is locked.
     *
     * @param stdClass|false $submission - assign_submission data if any
     * @param stdClass $flags - User flags record
     * @return void
     */
    public function lock($submission, stdClass $flags) {
    }

    /**
     * Carry out any extra processing required when the work is unlocked.
     *
     * @param stdClass|false $submission - assign_submission data if any
     * @param stdClass $flags - User flags record
     * @return void
     */
    public function unlock($submission, stdClass $flags) {
    }

    /**
     * Carry out any extra processing required when the work reverted to draft.
     *
     * @param stdClass $submission - assign_submission data
     * @return void
     */
    public function revert_to_draft(stdClass $submission) {
    }

    /**
     * Carry out any extra processing required when a student is given a new attempt
     * (i.e. when the submission is "reopened"
     * @param stdClass $oldsubmission The previous attempt
     * @param stdClass $newsubmission The new attempt
     */
    public function add_attempt(stdClass $oldsubmission, stdClass $newsubmission) {
    }

}
