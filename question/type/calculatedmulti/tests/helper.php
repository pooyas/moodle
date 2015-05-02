<?php

/**
 * Test helpers for the calculated question type.
 *
 * @package    qtype
 * @subpackage calculatedmulti
 * @copyright  2011 The Open University
 * 
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/type/calculated/question.php');


/**
 * Test helper class for the calculated multiple-choice question type.
 *
 * @copyright  2011 The Open University
 * 
 */
class qtype_calculatedmulti_test_helper extends question_test_helper {
    public function get_test_questions() {
        return array('sum');
    }

    /**
     * Makes a calculated multiple-choice question about summing two numbers.
     * @return qtype_calculatedmulti_question
     */
    public function make_calculatedmulti_question_sum() {
        // TODO.
        question_bank::load_question_definition_classes('calculated');
        $q = new qtype_calculatedmulti_question();
        test_question_maker::initialise_a_question($q);
        $q->name = 'Simple sum';
        $q->questiontext = 'What is {a} + {b}?';
        $q->generalfeedback = 'Generalfeedback: {={a} + {b}} is the right answer.';
        $q->answers = array(
            13 => new qtype_numerical_answer(13, '{a} + {b}', 1.0, 'Very good.', FORMAT_HTML, 0),
            14 => new qtype_numerical_answer(14, '{a} - {b}', 0.0, 'Add. not subtract!.',
                    FORMAT_HTML, 0),
            17 => new qtype_numerical_answer(17, '*', 0.0, 'Completely wrong.', FORMAT_HTML, 0),
        );
        $q->qtype = question_bank::get_qtype('calculated');
        $q->unitdisplay = qtype_numerical::UNITNONE;
        $q->unitgradingtype = 0;
        $q->unitpenalty = 0;
        $q->ap = new qtype_numerical_answer_processor(array());

        $q->datasetloader = new qtype_calculated_test_dataset_loader(0, array(
            array('a' => 1, 'b' => 5),
            array('a' => 3, 'b' => 4),
        ));

        return $q;
    }
}
