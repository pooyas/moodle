<?php

/**
 * Unit tests for the radom shortanswer matching question definition classes.
 *
 * @package   qtype
 * @subpackage randomsamatch
 * @category   phpunit
 * @copyright 2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');


/**
 * Unit tests for the random shortanswer matching question definition class.
 *
 */
class qtype_randomsamatch_question_test extends advanced_testcase {

    public function test_get_expected_data() {
        $question = test_question_maker::make_question('randomsamatch');
        $question->start_attempt(new question_attempt_step(), 1);

        $this->assertEquals(array('sub0' => PARAM_INT, 'sub1' => PARAM_INT,
                'sub2' => PARAM_INT, 'sub3' => PARAM_INT), $question->get_expected_data());
    }

    public function test_is_complete_response() {
        $question = test_question_maker::make_question('randomsamatch');
        $question->start_attempt(new question_attempt_step(), 1);

        $this->assertFalse($question->is_complete_response(array()));
        $this->assertFalse($question->is_complete_response(
                array('sub0' => '1', 'sub1' => '1', 'sub2' => '1', 'sub3' => '0')));
        $this->assertFalse($question->is_complete_response(array('sub1' => '1')));
        $this->assertTrue($question->is_complete_response(
                array('sub0' => '1', 'sub1' => '1', 'sub2' => '1', 'sub3' => '1')));
    }

    public function test_is_gradable_response() {
        $question = test_question_maker::make_question('randomsamatch');
        $question->start_attempt(new question_attempt_step(), 1);

        $this->assertFalse($question->is_gradable_response(array()));
        $this->assertFalse($question->is_gradable_response(
                array('sub0' => '0', 'sub1' => '0', 'sub2' => '0', 'sub3' => '0')));
        $this->assertTrue($question->is_gradable_response(
                array('sub0' => '1', 'sub1' => '0', 'sub2' => '0', 'sub3' => '0')));
        $this->assertTrue($question->is_gradable_response(array('sub1' => '1')));
        $this->assertTrue($question->is_gradable_response(
                array('sub0' => '1', 'sub1' => '1', 'sub2' => '3', 'sub3' => '1')));
    }

    public function test_is_same_response() {
        $question = test_question_maker::make_question('randomsamatch');
        $question->start_attempt(new question_attempt_step(), 1);

        $this->assertTrue($question->is_same_response(
                array(),
                array('sub0' => '0', 'sub1' => '0', 'sub2' => '0', 'sub3' => '0')));

        $this->assertTrue($question->is_same_response(
                array('sub0' => '0', 'sub1' => '0', 'sub2' => '0', 'sub3' => '0'),
                array('sub0' => '0', 'sub1' => '0', 'sub2' => '0', 'sub3' => '0')));

        $this->assertFalse($question->is_same_response(
                array('sub0' => '0', 'sub1' => '0', 'sub2' => '0', 'sub3' => '0'),
                array('sub0' => '1', 'sub1' => '2', 'sub2' => '3', 'sub3' => '1')));

        $this->assertTrue($question->is_same_response(
                array('sub0' => '1', 'sub1' => '2', 'sub2' => '3', 'sub3' => '1'),
                array('sub0' => '1', 'sub1' => '2', 'sub2' => '3', 'sub3' => '1')));

        $this->assertFalse($question->is_same_response(
                array('sub0' => '2', 'sub1' => '2', 'sub2' => '3', 'sub3' => '1'),
                array('sub0' => '1', 'sub1' => '2', 'sub2' => '3', 'sub3' => '1')));
    }

    public function test_grading() {
        $question = test_question_maker::make_question('randomsamatch');
        $question->start_attempt(new question_attempt_step(), 1);

        $choiceorder = $question->get_choice_order();
        $orderforchoice = array_combine(array_values($choiceorder), array_keys($choiceorder));
        $this->assertEquals(array(1, question_state::$gradedright),
                $question->grade_response(array('sub0' => $orderforchoice[13],
                        'sub1' => $orderforchoice[16], 'sub2' => $orderforchoice[16],
                        'sub3' => $orderforchoice[13])));
        $this->assertEquals(array(0.25, question_state::$gradedpartial),
                $question->grade_response(array('sub0' => $orderforchoice[13])));
        $this->assertEquals(array(0, question_state::$gradedwrong),
                $question->grade_response(array('sub0' => $orderforchoice[16],
                        'sub1' => $orderforchoice[13], 'sub2' => $orderforchoice[13],
                        'sub3' => $orderforchoice[16])));
    }

    public function test_get_correct_response() {
        $question = test_question_maker::make_question('randomsamatch');
        $question->start_attempt(new question_attempt_step(), 1);

        $choiceorder = $question->get_choice_order();
        $orderforchoice = array_combine(array_values($choiceorder), array_keys($choiceorder));

        $this->assertEquals(array('sub0' => $orderforchoice[13], 'sub1' => $orderforchoice[16],
                'sub2' => $orderforchoice[16], 'sub3' => $orderforchoice[13]),
                $question->get_correct_response());
    }

    public function test_get_question_summary() {
        $question = test_question_maker::make_question('randomsamatch');
        $question->start_attempt(new question_attempt_step(), 1);
        $qsummary = $question->get_question_summary();
        $this->assertRegExp('/' . preg_quote($question->questiontext, '/') . '/', $qsummary);
        foreach ($question->stems as $stem) {
            $this->assertRegExp('/' . preg_quote($stem, '/') . '/', $qsummary);
        }
        foreach ($question->choices as $choice) {
            $this->assertRegExp('/' . preg_quote($choice, '/') . '/', $qsummary);
        }
    }

    public function test_summarise_response() {
        $question = test_question_maker::make_question('randomsamatch');
        $question->shufflestems = false;
        $question->start_attempt(new question_attempt_step(), 1);

        $summary = $question->summarise_response(array('sub0' => 2, 'sub1' => 1));

        $this->assertRegExp('/Dog -> \w+; Frog -> \w+/', $summary);
    }


}
