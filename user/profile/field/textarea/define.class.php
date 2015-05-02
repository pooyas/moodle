<?php

/**
 * Textarea profile field define.
 *
 * @package   profilefield_textarea
 * @copyright  2007 onwards Shane Elliot {@link http://pukunui.com}
 * 
 */

/**
 * Class profile_define_textarea.
 *
 * @copyright  2007 onwards Shane Elliot {@link http://pukunui.com}
 * 
 */
class profile_define_textarea extends profile_define_base {

    /**
     * Add elements for creating/editing a textarea profile field.
     * @param lionform $form
     */
    public function define_form_specific($form) {
        // Default data.
        $form->addElement('editor', 'defaultdata', get_string('profiledefaultdata', 'admin'));
        $form->setType('defaultdata', PARAM_RAW); // We have to trust person with capability to edit this default description.
    }

    /**
     * Returns an array of editors used when defining this type of profile field.
     * @return array
     */
    public function define_editors() {
        return array('defaultdata');
    }
}