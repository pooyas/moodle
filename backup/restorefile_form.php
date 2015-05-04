<?php

/**
 * Import backup file form
 * 
 * @package     core
 * @subpackage  backup
 * @copyright   2015 Pooya Saeedi
 * 
 */
require_once($CFG->libdir.'/formslib.php');

class course_restore_form extends lionform {
    function definition() {
        $mform =& $this->_form;
        $contextid = $this->_customdata['contextid'];
        $mform->addElement('hidden', 'contextid', $contextid);
        $mform->setType('contextid', PARAM_INT);
        $mform->addElement('filepicker', 'backupfile', get_string('files'));
        $submit_string = get_string('restore');
        $this->add_action_buttons(false, $submit_string);
    }
}
