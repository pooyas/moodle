<?php


/**
 * Add label form
 *
 * @package mod_label
 * @copyright  2006 Jamie Pratt
 * 
 */

defined('LION_INTERNAL') || die;

require_once ($CFG->dirroot.'/course/lionform_mod.php');

class mod_label_mod_form extends lionform_mod {

    function definition() {

        $mform = $this->_form;

        $mform->addElement('header', 'generalhdr', get_string('general'));
        $this->add_intro_editor(true, get_string('labeltext', 'label'));

        $this->standard_coursemodule_elements();

//-------------------------------------------------------------------------------
// buttons
        $this->add_action_buttons(true, false, null);

    }

}
