<?php

/**
 * True-false question definition class.
 *
 * @package    qtype
 * @subpackage truefalse
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Represents a true-false question.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class qtype_truefalse_question extends question_graded_automatically {
    public $rightanswer;
    public $truefeedback;
    public $falsefeedback;
    public $trueanswerid;
    public $falseanswerid;

    public function get_expected_data() {
        return array('answer' => PARAM_INT);
    }

    public function get_correct_response() {
        return array('answer' => (int) $this->rightanswer);
    }

    public function summarise_response(array $response) {
        if (!array_key_exists('answer', $response)) {
            return null;
        } else if ($response['answer']) {
            return get_string('true', 'qtype_truefalse');
        } else {
            return get_string('false', 'qtype_truefalse');
        }
    }

    public function classify_response(array $response) {
        if (!array_key_exists('answer', $response)) {
            return array($this->id => question_classified_response::no_response());
        }
        list($fraction) = $this->grade_response($response);
        if ($response['answer']) {
            return array($this->id => new question_classified_response(1,
                    get_string('true', 'qtype_truefalse'), $fraction));
        } else {
            return array($this->id => new question_classified_response(0,
                    get_string('false', 'qtype_truefalse'), $fraction));
        }
    }

    public function is_complete_response(array $response) {
        return array_key_exists('answer', $response);
    }

    public function get_validation_error(array $response) {
        if ($this->is_gradable_response($response)) {
            return '';
        }
        return get_string('pleaseselectananswer', 'qtype_truefalse');
    }

    public function is_same_response(array $prevresponse, array $newresponse) {
        return question_utils::arrays_same_at_key_missing_is_blank(
                $prevresponse, $newresponse, 'answer');
    }

    public function grade_response(array $response) {
        if ($this->rightanswer == true && $response['answer'] == true) {
            $fraction = 1;
        } else if ($this->rightanswer == false && $response['answer'] == false) {
            $fraction = 1;
        } else {
            $fraction = 0;
        }
        return array($fraction, question_state::graded_state_for_fraction($fraction));
    }

    public function check_file_access($qa, $options, $component, $filearea, $args, $forcedownload) {
        if ($component == 'question' && $filearea == 'answerfeedback') {
            $answerid = reset($args); // Itemid is answer id.
            $response = $qa->get_last_qt_var('answer', '');
            return $options->feedback && (
                    ($answerid == $this->trueanswerid && $response) ||
                    ($answerid == $this->falseanswerid && $response !== ''));

        } else {
            return parent::check_file_access($qa, $options, $component, $filearea,
                    $args, $forcedownload);
        }
    }
}
