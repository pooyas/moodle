<?php

/**
 * prints the form to confirm delete a completed
 *
 * @package    mod
 * @subpackage feedback
 * @copyright  2015 Pooya Saeedi
 */

//It must be included from a Lion page
if (!defined('LION_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

require_once($CFG->libdir.'/formslib.php');

class mod_feedback_delete_item_form extends lionform {
    public function definition() {
        $mform =& $this->_form;

        // hidden elements
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'deleteitem');
        $mform->setType('deleteitem', PARAM_INT);
        $mform->addElement('hidden', 'confirmdelete');
        $mform->setType('confirmdelete', PARAM_INT);

        //-------------------------------------------------------------------------------
        // buttons
        $this->add_action_buttons(true, get_string('yes'));

    }
}

