<?php

/**
 * @package    mod
 * @subpackage glossary
 * @copyright  2015 Pooya Saeedi
*/

if (!defined('LION_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Lion page
}

require_once($CFG->libdir.'/formslib.php');

class mod_glossary_import_form extends lionform {

    function definition() {
        global $CFG;
        $mform =& $this->_form;
        $cmid = $this->_customdata['id'];

        $mform->addElement('filepicker', 'file', get_string('filetoimport', 'glossary'));
        $mform->addHelpButton('file', 'filetoimport', 'glossary');
        $options = array();
        $options['current'] = get_string('currentglossary', 'glossary');
        $options['newglossary'] = get_string('newglossary', 'glossary');
        $mform->addElement('select', 'dest', get_string('destination', 'glossary'), $options);
        $mform->addHelpButton('dest', 'destination', 'glossary');
        $mform->addElement('checkbox', 'catsincl', get_string('importcategories', 'glossary'));
        $submit_string = get_string('submit');
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $this->add_action_buttons(false, $submit_string);
    }
}
