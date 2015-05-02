<?php

/**
 * Defines the editing form for the 'missingtype' question type.
 *
 * @package    qtype
 * @subpackage missingtype
 * @copyright  2007 Jamie Pratt
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * This question renderer class is used when the actual question type of this
 * question cannot be found.
 *
 * @copyright  2007 Jamie Pratt
 * 
 */
class qtype_missingtype_edit_form extends question_edit_form {
    public function __construct($submiturl, $question, $category, $contexts, $formeditable = true) {
        parent::__construct($submiturl, $question, $category, $contexts, false);
    }

    /**
     * Add question-type specific form fields.
     *
     * @param object $mform the form being built.
     */
    protected function definition_inner($mform) {
        $this->add_per_answer_fields($mform, get_string('answerno', 'qtype_missingtype', '{no}'),
                question_bank::fraction_options_full());
    }

    public function set_data($question) {
        if (isset($question->options) && is_array($question->options->answers)) {
            $answers = $question->options->answers;
            $default_values = array();
            $key = 0;
            foreach ($answers as $answer) {
                $default_values['answer['.$key.']'] = $answer->answer;
                $default_values['fraction['.$key.']'] = $answer->fraction;
                $default_values['feedback['.$key.']'] = $answer->feedback;
                $key++;
            }
            $question = (object)((array)$question + $default_values);
        }
        parent::set_data($question);
    }

    public function qtype() {
        return 'missingtype';
    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        $errors['name'] = get_string('cannotchangeamissingqtype', 'qtype_missingtype');
        return $errors;
    }
}
