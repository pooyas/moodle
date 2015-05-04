<?php

/**
 * Manage backup files
 * 
 * @package     core
 * @subpackage  backup
 * @copyright   2015 Pooya Saeedi
 */
require_once($CFG->libdir.'/formslib.php');

class backup_files_edit_form extends lionform {

    /**
     * Form definition.
     */
    public function definition() {
        $mform =& $this->_form;

        $options = array('subdirs' => 0, 'maxfiles' => -1, 'accepted_types' => '*', 'return_types' => FILE_INTERNAL | FILE_REFERENCE);

        $mform->addElement('filemanager', 'files_filemanager', get_string('files'), null, $options);

        $mform->addElement('hidden', 'contextid', $this->_customdata['contextid']);
        $mform->setType('contextid', PARAM_INT);

        $mform->addElement('hidden', 'currentcontext', $this->_customdata['currentcontext']);
        $mform->setType('currentcontext', PARAM_INT);

        $mform->addElement('hidden', 'filearea', $this->_customdata['filearea']);
        $mform->setType('filearea', PARAM_AREA);

        $mform->addElement('hidden', 'component', $this->_customdata['component']);
        $mform->setType('component', PARAM_COMPONENT);

        $mform->addElement('hidden', 'returnurl', $this->_customdata['returnurl']);
        $mform->setType('returnurl', PARAM_URL);

        $this->add_action_buttons(true, get_string('savechanges'));
        $this->set_data($this->_customdata['data']);
    }
}
