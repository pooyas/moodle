<?php


/**
 * This file defines interface of all grading evaluation classes
 *
 * @package    mod
 * @subpackage workshop
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/lib/formslib.php');

/**
 * Base class for all grading evaluation subplugins.
 */
abstract class workshop_evaluation {

    /**
     * Calculates grades for assessment and updates 'gradinggrade' fields in 'workshop_assessments' table
     *
     * @param stdClass $settings settings for this round of evaluation
     * @param null|int|array $restrict if null, update all reviewers, otherwise update just grades for the given reviewers(s)
     */
    abstract public function update_grading_grades(stdClass $settings, $restrict=null);

    /**
     * Returns an instance of the form to provide evaluation settings.
      *
     * This is called by view.php (to display) and aggregate.php (to process and dispatch).
     * It returns the basic form with just the submit button by default. Evaluators may
     * extend or overwrite the default form to include some custom settings.
     *
     * @return workshop_evaluation_settings_form
     */
    public function get_settings_form(lion_url $actionurl=null) {

        $customdata = array('workshop' => $this->workshop);
        $attributes = array('class' => 'evalsettingsform');

        return new workshop_evaluation_settings_form($actionurl, $customdata, 'post', '', $attributes);
    }

    /**
     * Delete all data related to a given workshop module instance
     *
     * This is called from {@link workshop_delete_instance()}.
     *
     * @param int $workshopid id of the workshop module instance being deleted
     * @return void
     */
    public static function delete_instance($workshopid) {

    }
}


/**
 * Base form to hold eventual evaluation settings.
 */
class workshop_evaluation_settings_form extends lionform {

    /**
     * Defines the common form fields.
     */
    public function definition() {
        $mform = $this->_form;

        $workshop = $this->_customdata['workshop'];

        $mform->addElement('header', 'general', get_string('evaluationsettings', 'mod_workshop'));

        $this->definition_sub();

        $mform->addElement('submit', 'submit', get_string('aggregategrades', 'workshop'));
    }

    /**
     * Defines the subplugin specific fields.
     */
    protected function definition_sub() {
    }
}
