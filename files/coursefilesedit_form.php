<?php




/**
 * @package    core
 * @subpackage files
 * @copyright  2015 Pooya Saeedi
*/

require_once($CFG->libdir.'/formslib.php');

class coursefiles_edit_form extends lionform {
    function definition() {
        global $CFG;

        $maxfiles = 0;
        $subdirs = 0;
        if ($CFG->legacyfilesaddallowed) {
            $maxfiles = -1;
            $subdirs = 1;
        }

        $mform =& $this->_form;
        $contextid = $this->_customdata['contextid'];
        $options = array('subdirs' => $subdirs, 'maxfiles' => $maxfiles, 'accepted_types'=>'*');
        $mform->addElement('filemanager', 'files_filemanager', '', null, $options);
        $mform->addElement('hidden', 'contextid', $this->_customdata['contextid']);
        $mform->setType('contextid', PARAM_INT);
        $this->set_data($this->_customdata['data']);
        $this->add_action_buttons(true);
    }
}
