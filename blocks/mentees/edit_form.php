<?php

/**
 * Form for editing Mentees block instances.
 *
 * @package   block_mentees
 * @copyright 2009 Tim Hunt
 * 
 */

/**
 * Form for editing Mentees block instances.
 *
 * @copyright 2009 Tim Hunt
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