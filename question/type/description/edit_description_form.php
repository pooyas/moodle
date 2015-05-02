<?php

/**
 * Defines the editing form for the description question type.
 *
 * @package    qtype
 * @subpackage description
 * @copyright  2007 Jamie Pratt
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Description editing form definition.
 *
 * @copyright  2007 Jamie Pratt
 * 
 */
class qtype_description_edit_form extends question_edit_form {
    /**
     * Add question-type specific form fields.
     *
     * @param LionQuickForm $mform the form being built.
     */
    protected function definition_inner($mform) {
        // We don't need this default element.
        $mform->removeElement('defaultmark');
        $mform->addElement('hidden', 'defaultmark', 0);
        $mform->setType('defaultmark', PARAM_RAW);
    }

    public function qtype() {
        return 'description';
    }
}
