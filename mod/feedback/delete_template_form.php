<?php

/**
 * prints the form to confirm delete a completed
 *
 * @author Andreas Grabs
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package mod_feedback
 */

//It must be included from a Lion page
if (!defined('LION_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

require_once($CFG->libdir.'/formslib.php');

class mod_feedback_delete_template_form extends lionform {
    public function definition() {
        $mform =& $this->_form;

        // hidden elements
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'deletetempl');
        $mform->setType('deletetempl', PARAM_INT);
        $mform->addElement('hidden', 'confirmdelete');
        $mform->setType('confirmdelete', PARAM_INT);

        //-------------------------------------------------------------------------------
        // buttons
        $this->add_action_buttons(true, get_string('yes'));

    }
}
