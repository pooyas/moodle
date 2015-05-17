<?php


/**
 * Textarea profile field define.
 *
 * @package    user
 * @subpackage profile
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Class profile_define_textarea.
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