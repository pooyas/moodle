<?php

/**
 * Form for moving questions between categories.
 *
 * @package    core
 * @subpackage questionbank
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');


/**
 * Form for moving questions between categories.
 *
 */
class question_move_form extends lionform {
    protected function definition() {
        $mform = $this->_form;

        $currentcat = $this->_customdata['currentcat'];
        $contexts = $this->_customdata['contexts'];

        $mform->addElement('questioncategory', 'category', get_string('category', 'question'), compact('contexts', 'currentcat'));

        $this->add_action_buttons(true, get_string('categorymoveto', 'question'));

        $mform->addElement('hidden', 'delete', $currentcat);
        $mform->setType('delete', PARAM_INT);
    }
}
