<?php


/**
 * Defines the 'qtype_missingtype' question definition class.
 *
 * @package    question_type
 * @subpackage missingtype
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();


/**
 * This question definition class is used when the actual question type of this
 * question cannot be found.
 *
 * Why does this this class implement question_automatically_gradable? I am not
 * sure at the moment. Perhaps it is important for it to work with as many
 * behaviours as possible.
 *
 */
class qtype_missingtype_question extends question_definition
        implements question_automatically_gradable {
    public function get_expected_data() {
        return array();
    }

    public function get_correct_response() {
        return array();
    }

    public function is_complete_response(array $response) {
        return false;
    }

    public function is_gradable_response(array $response) {
        return false;
    }

    public function get_validation_error(array $response) {
        return '';
    }

    public function is_same_response(array $prevresponse, array $newresponse) {
        return true;
    }

    public function get_right_answer_summary() {
        return '';
    }

    public function summarise_response(array $response) {
        return null;
    }

    public function classify_response(array $response) {
        return array();
    }

    public function start_attempt(question_attempt_step $step, $variant) {
        throw new coding_exception('This question is of a type that is not installed ' .
                'on your system. No processing is possible.');
    }

    public function grade_response(array $response) {
        throw new coding_exception('This question is of a type that is not installed ' .
                'on your system. No processing is possible.');
    }

    public function get_hint($hintnumber, question_attempt $qa) {
        return null;
    }
}
