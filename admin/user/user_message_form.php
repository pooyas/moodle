<?php

/**
 * script for bulk user message form
 * @package    core
 * @subpackage user
 * @copyright  2015 Pooya Saeedi
 */

if (!defined('LION_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Lion page
}

require_once($CFG->libdir.'/formslib.php');

class user_message_form extends lionform {

    function definition() {
        $mform =& $this->_form;
        $mform->addElement('header', 'general', get_string('message', 'message'));


        $mform->addElement('editor', 'messagebody', get_string('messagebody'), null, null);
        $mform->addRule('messagebody', '', 'required', null, 'server');

        $this->add_action_buttons();
    }
}
