<?php


/**
 * Defines the editing form for the shortanswer question type.
 *
 * @package    question_type
 * @subpackage shortanswer
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();


/**
 * Short answer question editing form definition.
 *
 */
class qtype_shortanswer_edit_form extends question_edit_form {

    protected function definition_inner($mform) {
        $menu = array(
            get_string('caseno', 'qtype_shortanswer'),
            get_string('caseyes', 'qtype_shortanswer')
        );
        $mform->addElement('select', 'usecase',
                get_string('casesensitive', 'qtype_shortanswer'), $menu);

        $mform->addElement('static', 'answersinstruct',
                get_string('correctanswers', 'qtype_shortanswer'),
                get_string('filloutoneanswer', 'qtype_shortanswer'));
        $mform->closeHeaderBefore('answersinstruct');

        $this->add_per_answer_fields($mform, get_string('answerno', 'qtype_shortanswer', '{no}'),
                question_bank::fraction_options());

        $this->add_interactive_settings();
    }

    protected function get_more_choices_string() {
        return get_string('addmoreanswerblanks', 'qtype_shortanswer');
    }

    protected function data_preprocessing($question) {
        $question = parent::data_preprocessing($question);
        $question = $this->data_preprocessing_answers($question);
        $question = $this->data_preprocessing_hints($question);

        return $question;
    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        $answers = $data['answer'];
        $answercount = 0;
        $maxgrade = false;
        foreach ($answers as $key => $answer) {
            $trimmedanswer = trim($answer);
            if ($trimmedanswer !== '') {
                $answercount++;
                if ($data['fraction'][$key] == 1) {
                    $maxgrade = true;
                }
            } else if ($data['fraction'][$key] != 0 ||
                    !html_is_blank($data['feedback'][$key]['text'])) {
                $errors["answeroptions[{$key}]"] = get_string('answermustbegiven', 'qtype_shortanswer');
                $answercount++;
            }
        }
        if ($answercount==0) {
            $errors['answeroptions[0]'] = get_string('notenoughanswers', 'qtype_shortanswer', 1);
        }
        if ($maxgrade == false) {
            $errors['answeroptions[0]'] = get_string('fractionsnomax', 'question');
        }
        return $errors;
    }

    public function qtype() {
        return 'shortanswer';
    }
}
