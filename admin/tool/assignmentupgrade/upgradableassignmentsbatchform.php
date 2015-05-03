<?php

/**
 * This file contains the forms to create and edit an instance of this module
 *
 * @package    tool
 * @subpackage assignmentupgrade
 * @copyright 2015 Pooya Saeedi {@link http://www.netspot.com.au}
 * 
 */

defined('LION_INTERNAL') || die('Direct access to this script is forbidden.');

require_once($CFG->libdir.'/formslib.php');

/**
 * Assignment upgrade batch operations form.
 *
 */
class tool_assignmentupgrade_batchoperations_form extends lionform {
    /**
     * Define this form - is called from parent constructor.
     */
    public function definition() {
        $mform = $this->_form;
        $instance = $this->_customdata;

        $mform->addElement('header', 'general', get_string('batchoperations', 'tool_assignmentupgrade'));
        // Visible elements.
        $mform->addElement('hidden', 'selectedassignments', '', array('class'=>'selectedassignments'));
        $mform->setType('selectedassignments', PARAM_SEQUENCE);

        $mform->addElement('submit', 'upgradeselected', get_string('upgradeselected', 'tool_assignmentupgrade'));
        $mform->addElement('submit', 'upgradeall', get_string('upgradeall', 'tool_assignmentupgrade'));
    }

}

