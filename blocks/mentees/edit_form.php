<?php

/**
 * Form for editing Mentees block instances.
 *
 * @package    block
 * @subpackage mentees
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Form for editing Mentees block instances.
 *
 */
class block_mentees_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('configtitleblankhides', 'block_mentees'));
        $mform->setType('config_title', PARAM_TEXT);
    }
}