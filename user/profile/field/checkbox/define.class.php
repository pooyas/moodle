<?php

/**
 * Checkbox profile field
 *
 * @package   profilefield
 * @subpackage checkbox
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Class profile_define_checkbox
 * 
 */
class profile_define_checkbox extends profile_define_base {

    /**
     * Add elements for creating/editing a checkbox profile field.
     *
     * @param lionform $form
     */
    public function define_form_specific($form) {
        // Select whether or not this should be checked by default.
        $form->addElement('selectyesno', 'defaultdata', get_string('profiledefaultchecked', 'admin'));
        $form->setDefault('defaultdata', 0); // Defaults to 'no'.
        $form->setType('defaultdata', PARAM_BOOL);
    }
}


