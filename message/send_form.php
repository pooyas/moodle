<?php

/**
 * Contains the definition of the form used to send messages
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */
if (!defined('LION_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Lion page
}

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * The form used by users to send instant messages
 *
 */
class send_form extends lionform {

    /**
     * Define the mform elements required
     */
    function definition () {

        $mform =& $this->_form;

        $editoroptions = array();

        //width handled by css so cols is empty. Still present so the page validates.
        $displayoptions = array('rows'=>'4', 'cols'=>'', 'class'=>'messagesendbox');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'viewing');
        $mform->setType('viewing', PARAM_ALPHANUMEXT);

        $mform->addElement('textarea', 'message', get_string('message', 'message'), $displayoptions, $editoroptions);

        $this->add_action_buttons(false, get_string('sendmessage', 'message'));
    }
}

?>
