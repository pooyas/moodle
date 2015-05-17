<?php


/**
 * Calculated question renderer class.
 *
 * @package    question_type
 * @subpackage calculated
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/numerical/renderer.php');


/**
 * Generates the output for calculated questions.
 *
 */
class qtype_calculated_renderer extends qtype_numerical_renderer {
    public function correct_response(question_attempt $qa) {
        $question = $qa->get_question();
        $answer = $question->get_correct_response();
        if (!$answer) {
            return '';
        }

        $response = $answer['answer'];
        if ($question->unitdisplay != qtype_numerical::UNITNONE && $question->unitdisplay != qtype_numerical::UNITINPUT) {
            $response = $question->ap->add_unit($response);
        }

        return get_string('correctansweris', 'qtype_shortanswer', $response);
    }

}
