<?php

/**
 * This file contains the forms to create and edit an instance of this module
 *
 * @package    tool
 * @subpackage assignmentupgrade
 * @copyright 2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die('Direct access to this script is forbidden.');

require_once($CFG->libdir.'/formslib.php');

/**
 * Assignment upgrade table display options
 *
 */
class tool_assignmentupgrade_pagination_form extends lionform {
    /**
     * Define this form - called from the parent constructor
     */
    public function definition() {
        $mform = $this->_form;
        $instance = $this->_customdata;

        $mform->addElement('header', 'general', get_string('assignmentsperpage', 'tool_assignmentupgrade'));
        // Visible elements.
        $options = array(10=>'10', 20=>'20', 50=>'50', 100=>'100');
        $mform->addElement('select', 'perpage', get_string('assignmentsperpage', 'assign'), $options);

        // Hidden params.
        $mform->addElement('hidden', 'action', 'saveoptions');
        $mform->setType('action', PARAM_ALPHA);

        // Buttons.
        $this->add_action_buttons(false, get_string('updatetable', 'tool_assignmentupgrade'));
    }
}

