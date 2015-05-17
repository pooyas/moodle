<?php


/**
 * This file contains the forms to create and edit an instance of this module
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die('Direct access to this script is forbidden.');


require_once($CFG->libdir.'/formslib.php');
require_once($CFG->dirroot . '/mod/assign/locallib.php');

/**
 * Assignment extension dates form
 *
 */
class mod_assign_extension_form extends lionform {
    /** @var array $instance - The data passed to this form */
    private $instance;

    /**
     * Define the form - called by parent constructor
     */
    public function definition() {
        $mform = $this->_form;

        list($coursemoduleid, $userid, $batchusers, $instance, $data) = $this->_customdata;
        // Instance variable is used by the form validation function.
        $this->instance = $instance;

        if ($batchusers) {
            $listusersmessage = get_string('grantextensionforusers', 'assign', count(explode(',', $batchusers)));
            $mform->addElement('static', 'applytoselectedusers', '', $listusersmessage);
        }
        if ($instance->allowsubmissionsfromdate) {
            $mform->addElement('static', 'allowsubmissionsfromdate', get_string('allowsubmissionsfromdate', 'assign'),
                               userdate($instance->allowsubmissionsfromdate));
        }
        if ($instance->duedate) {
            $mform->addElement('static', 'duedate', get_string('duedate', 'assign'), userdate($instance->duedate));
            $finaldate = $instance->duedate;
        }
        if ($instance->cutoffdate) {
            $mform->addElement('static', 'cutoffdate', get_string('cutoffdate', 'assign'), userdate($instance->cutoffdate));
            $finaldate = $instance->cutoffdate;
        }
        $mform->addElement('date_time_selector', 'extensionduedate',
                           get_string('extensionduedate', 'assign'), array('optional'=>true));
        $mform->setDefault('extensionduedate', $finaldate);
        $mform->addElement('hidden', 'id', $coursemoduleid);
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'userid', $userid);
        $mform->setType('userid', PARAM_INT);
        $mform->addElement('hidden', 'selectedusers', $batchusers);
        $mform->setType('selectedusers', PARAM_SEQUENCE);
        $mform->addElement('hidden', 'action', 'saveextension');
        $mform->setType('action', PARAM_ALPHA);
        $this->add_action_buttons(true, get_string('savechanges', 'assign'));

        if ($data) {
            $this->set_data($data);
        }
    }

    /**
     * Perform validation on the extension form
     * @param array $data
     * @param array $files
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        if ($this->instance->duedate && $data['extensionduedate']) {
            if ($this->instance->duedate > $data['extensionduedate']) {
                $errors['extensionduedate'] = get_string('extensionnotafterduedate', 'assign');
            }
        }
        if ($this->instance->allowsubmissionsfromdate && $data['extensionduedate']) {
            if ($this->instance->allowsubmissionsfromdate > $data['extensionduedate']) {
                $errors['extensionduedate'] = get_string('extensionnotafterfromdate', 'assign');
            }
        }

        return $errors;
    }
}
