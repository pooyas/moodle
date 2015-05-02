<?php

/**
 * Defines forms used by pick.php
 *
 * @package    core_grading
 * @copyright  2011 David Mudrak <david@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * Allows to search for a specific shared template
 *
 * @package    core_grading
 * @copyright  2011 David Mudrak <david@lion.com>
 * 
 */
class grading_search_template_form extends lionform {

    /**
     * Pretty simple search box
     */
    public function definition() {
        $mform = $this->_form;
        $mform->addElement('header', 'searchheader', get_string('searchtemplate', 'core_grading'));
        $mform->addHelpButton('searchheader', 'searchtemplate', 'core_grading');
        $mform->addGroup(array(
            $mform->createElement('checkbox', 'mode', '', get_string('searchownforms', 'core_grading')),
            $mform->createElement('text', 'needle', '', array('size' => 30)),
            $mform->createElement('submit', 'submitbutton', get_string('search')),
        ), 'buttonar', '', array(' '), false);
        $mform->setType('needle', PARAM_TEXT);
        $mform->setType('buttonar', PARAM_RAW);
    }
}
