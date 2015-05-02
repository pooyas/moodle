<?php

/**
 * Form for grade history filters
 *
 * @package    gradereport_history
 * @copyright  2013 NetSpot Pty Ltd (https://www.netspot.com.au)
 * @author     Adam Olley <adam.olley@netspot.com.au>
 * 
 */

namespace gradereport_history;

defined('LION_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');

/**
 * Form for grade history filters
 *
 * @since      Lion 2.8
 * @package    gradereport_history
 * @copyright  2013 NetSpot Pty Ltd (https://www.netspot.com.au)
 * @author     Adam Olley <adam.olley@netspot.com.au>
 * 
 */
class filter_form extends \lionform {

    /**
     * Definition of the Mform for filters displayed in the report.
     */
    public function definition() {

        $mform    = $this->_form;
        $course   = $this->_customdata['course'];
        $itemids  = $this->_customdata['itemids'];
        $graders  = $this->_customdata['graders'];
        $userbutton = $this->_customdata['userbutton'];
        $names = \html_writer::span('', 'selectednames');

        $mform->addElement('static', 'userselect', get_string('selectusers', 'gradereport_history'), $userbutton);
        $mform->addElement('static', 'selectednames', get_string('selectedusers', 'gradereport_history'), $names);

        $mform->addElement('select', 'itemid', get_string('gradeitem', 'grades'), $itemids);
        $mform->setType('itemid', PARAM_INT);

        $mform->addElement('select', 'grader', get_string('grader', 'gradereport_history'), $graders);
        $mform->setType('grader', PARAM_INT);

        $mform->addElement('date_selector', 'datefrom', get_string('datefrom', 'gradereport_history'), array('optional' => true));
        $mform->addElement('date_selector', 'datetill', get_string('dateto', 'gradereport_history'), array('optional' => true));

        $mform->addElement('checkbox', 'revisedonly', get_string('revisedonly', 'gradereport_history'));
        $mform->addHelpButton('revisedonly', 'revisedonly', 'gradereport_history');

        $mform->addElement('hidden', 'id', $course->id);
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden', 'userids');
        $mform->setType('userids', PARAM_SEQUENCE);

        $mform->addElement('hidden', 'userfullnames');
        $mform->setType('userfullnames', PARAM_TEXT);

        // Add a submit button.
        $mform->addElement('submit', 'submitbutton', get_string('submit'));
    }

    /**
     * This method implements changes to the form that need to be made once the form data is set.
     */
    public function definition_after_data() {
        $mform = $this->_form;

        if ($userfullnames = $mform->getElementValue('userfullnames')) {
            $mform->getElement('selectednames')->setValue(\html_writer::span($userfullnames, 'selectednames'));
        }
    }

}
