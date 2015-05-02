<?php

/**
 * Defines the export questions form.
 *
 * @package    lioncore
 * @subpackage questionbank
 * @copyright  2007 Jamie Pratt me@jamiep.org
 * 
 */


defined('LION_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');


/**
 * Form to export questions from the question bank.
 *
 * @copyright  2007 Jamie Pratt me@jamiep.org
 * 
 */
class question_export_form extends lionform {

    protected function definition() {
        $mform = $this->_form;

        $defaultcategory = $this->_customdata['defaultcategory'];
        $contexts = $this->_customdata['contexts'];

        // Choice of format, with help.
        $mform->addElement('header', 'fileformat', get_string('fileformat', 'question'));
        $fileformatnames = get_import_export_formats('export');
        $radioarray = array();
        $i = 0 ;
        foreach ($fileformatnames as $shortname => $fileformatname) {
            $currentgrp1 = array();
            $currentgrp1[] = $mform->createElement('radio', 'format', '', $fileformatname, $shortname);
            $mform->addGroup($currentgrp1, "formathelp[{$i}]", '', array('<br />'), false);

            if (get_string_manager()->string_exists('pluginname_help', 'qformat_' . $shortname)) {
                $mform->addHelpButton("formathelp[{$i}]", 'pluginname', 'qformat_' . $shortname);
            }

            $i++ ;
        }
        $mform->addRule("formathelp[0]", null, 'required', null, 'client');

        // Export options.
        $mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('questioncategory', 'category', get_string('exportcategory', 'question'), compact('contexts'));
        $mform->setDefault('category', $defaultcategory);
        $mform->addHelpButton('category', 'exportcategory', 'question');

        $categorygroup = array();
        $categorygroup[] = $mform->createElement('checkbox', 'cattofile', '', get_string('tofilecategory', 'question'));
        $categorygroup[] = $mform->createElement('checkbox', 'contexttofile', '', get_string('tofilecontext', 'question'));
        $mform->addGroup($categorygroup, 'categorygroup', '', '', false);
        $mform->disabledIf('categorygroup', 'cattofile', 'notchecked');
        $mform->setDefault('cattofile', 1);
        $mform->setDefault('contexttofile', 1);

        // Set a template for the format select elements
        $renderer = $mform->defaultRenderer();
        $template = "{help} {element}\n";
        $renderer->setGroupElementTemplate($template, 'format');

        // Submit buttons.
        $this->add_action_buttons(false, get_string('exportquestions', 'question'));
    }
}
