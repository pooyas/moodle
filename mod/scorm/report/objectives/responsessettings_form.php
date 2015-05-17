<?php


/**
 * Defines the version of scorm_objectives
 * @package    mod
 * @subpackage scorm
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");
/**
 * A form that displays the objective report settings
 *
 */
class mod_scorm_report_objectives_settings extends lionform {
    /**
     * Definition of the setting form elements
     */
    protected function definition() {
        global $COURSE;
        $mform    =& $this->_form;

        $mform->addElement('header', 'preferencespage', get_string('preferencespage', 'scorm'));

        $options = array();
        if ($COURSE->id != SITEID) {
            $options[SCORM_REPORT_ATTEMPTS_ALL_STUDENTS] = get_string('optallstudents', 'scorm');
            $options[SCORM_REPORT_ATTEMPTS_STUDENTS_WITH] = get_string('optattemptsonly', 'scorm');
            $options[SCORM_REPORT_ATTEMPTS_STUDENTS_WITH_NO] = get_string('optnoattemptsonly', 'scorm');
        }
        $mform->addElement('select', 'attemptsmode', get_string('show', 'scorm'), $options);
        $mform->addElement('advcheckbox', 'objectivescore', '', get_string('objectivescore', 'scormreport_objectives'));

        $mform->addElement('header', 'preferencesuser', get_string('preferencesuser', 'scorm'));

        $mform->addElement('text', 'pagesize', get_string('pagesize', 'scorm'));
        $mform->setType('pagesize', PARAM_INT);

        $this->add_action_buttons(false, get_string('savepreferences'));
    }
}
