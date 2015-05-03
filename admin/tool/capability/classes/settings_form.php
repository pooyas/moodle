<?php

/**
 * Capability tool settings form.
 *
 * Do no include this file, it is automatically loaded by the class loader!
 *
 * @package    tool
 * @subpackage capability
 * @copyright  2015 Pooya Saeedi
 * 
 */

require_once($CFG->libdir.'/formslib.php');

/**
 * Class tool_capability_settings_form
 *
 * The settings form for the comparison of roles/capabilities.
 *
 */
class tool_capability_settings_form extends lionform {

    /**
     * The form definition.
     */
    public function definition() {
        $form = $this->_form;
        $capabilities = $this->_customdata['capabilities'];
        $roles = $this->_customdata['roles'];
        // Set the form ID.
        $form->setAttributes(array('id' => 'capability-overview-form') + $form->getAttributes());

        $form->addElement('header', 'reportsettings', get_string('reportsettings', 'tool_capability'));
        $form->addElement('html', html_writer::tag('p', get_string('intro', 'tool_capability'), array('id' => 'intro')));

        $form->addElement('hidden', 'search');
        $form->setType('search', PARAM_TEXT);

        $attributes = array('multiple' => 'multiple', 'size' => 10, 'data-search' => 'capability');
        $form->addElement('select', 'capability', get_string('capabilitylabel', 'tool_capability'), $capabilities, $attributes);
        $form->setType('capability', PARAM_CAPABILITY);

        $attributes = array('multiple' => 'multiple', 'size' => 10);
        $form->addElement('select', 'roles', get_string('roleslabel', 'tool_capability'), $roles, $attributes);
        $form->setType('roles', PARAM_TEXT);

        $form->addElement('submit', 'submitbutton', get_string('getreport', 'tool_capability'));
    }

}