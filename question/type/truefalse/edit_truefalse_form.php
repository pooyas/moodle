<?php

/**
 * Defines the editing form for the true-false question type.
 *
 * @package    qtype
 * @subpackage truefalse
 * @copyright  2007 Jamie Pratt
 * 
 */


defined('LION_INTERNAL') || die();


require_once($CFG->dirroot.'/question/type/edit_question_form.php');


/**
 * True-false question editing form definition.
 *
 * @copyright  2007 Jamie Pratt
 * 
 */
class qtype_truefalse_edit_form extends question_edit_form {
    /**
     * Add question-type specific form fields.
     *
     * @param object $mform the form being built.
     */
    protected function definition_inner($mform) {
        $mform->addElement('select', 'correctanswer',
                get_string('correctanswer', 'qtype_truefalse'), array(
                0 => get_string('false', 'qtype_truefalse'),
                1 => get_string('true', 'qtype_truefalse')));

        $mform->addElement('editor', 'feedbacktrue',
                get_string('feedbacktrue', 'qtype_truefalse'), array('rows' => 10), $this->editoroptions);
        $mform->setType('feedbacktrue', PARAM_RAW);

        $mform->addElement('editor', 'feedbackfalse',
                get_string('feedbackfalse', 'qtype_truefalse'), array('rows' => 10), $this->editoroptions);
        $mform->setType('feedbackfalse', PARAM_RAW);

        $mform->addElement('header', 'multitriesheader',
                get_string('settingsformultipletries', 'question'));

        $mform->addElement('hidden', 'penalty', 1);
        $mform->setType('penalty', PARAM_FLOAT);

        $mform->addElement('static', 'penaltymessage',
                get_string('penaltyforeachincorrecttry', 'question'), 1);
        $mform->addHelpButton('penaltymessage', 'penaltyforeachincorrecttry', 'question');
    }

    public function data_preprocessing($question) {
        $question = parent::data_preprocessing($question);

        if (!empty($question->options->trueanswer)) {
            $trueanswer = $question->options->answers[$question->options->trueanswer];
            $question->correctanswer = ($trueanswer->fraction != 0);

            $draftid = file_get_submitted_draft_itemid('trueanswer');
            $answerid = $question->options->trueanswer;

            $question->feedbacktrue = array();
            $question->feedbacktrue['format'] = $trueanswer->feedbackformat;
            $question->feedbacktrue['text'] = file_prepare_draft_area(
                $draftid,             // Draftid
                $this->context->id,   // context
                'question',           // component
                'answerfeedback',     // filarea
                !empty($answerid) ? (int) $answerid : null, // itemid
                $this->fileoptions,   // options
                $trueanswer->feedback // text.
            );
            $question->feedbacktrue['itemid'] = $draftid;
        }

        if (!empty($question->options->falseanswer)) {
            $falseanswer = $question->options->answers[$question->options->falseanswer];

            $draftid = file_get_submitted_draft_itemid('falseanswer');
            $answerid = $question->options->falseanswer;

            $question->feedbackfalse = array();
            $question->feedbackfalse['format'] = $falseanswer->feedbackformat;
            $question->feedbackfalse['text'] = file_prepare_draft_area(
                $draftid,              // Draftid
                $this->context->id,    // context
                'question',            // component
                'answerfeedback',      // filarea
                !empty($answerid) ? (int) $answerid : null, // itemid
                $this->fileoptions,    // options
                $falseanswer->feedback // text.
            );
            $question->feedbackfalse['itemid'] = $draftid;
        }

        return $question;
    }

    public function qtype() {
        return 'truefalse';
    }
}
