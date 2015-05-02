<?php


/**
 * A lion form to manage folder files
 *
 * @package   mod_folder
 * @copyright 2010 Dongsheng Cai <dongsheng@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class mod_folder_edit_form extends lionform {
    function definition() {
        $mform = $this->_form;

        $data    = $this->_customdata['data'];
        $options = $this->_customdata['options'];

        $mform->addElement('hidden', 'id', $data->id);
        $mform->setType('id', PARAM_INT);
        $mform->addElement('filemanager', 'files_filemanager', get_string('files'), null, $options);
        $submit_string = get_string('savechanges');
        $this->add_action_buttons(true, $submit_string);

        $this->set_data($data);
    }
}
