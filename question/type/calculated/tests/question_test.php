<?php


/**
 * Unit tests for the calculated question definition class.
 *
 * @package    qtype
 * @subpackage calculated
 * @copyright  2011 The Open University
 * 
 */

defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');


/**
 * Unit tests for qtype_calculated_definition.
 *
 * @copyright  2011 The Open University
 * 
 */
class qtype_calculated_question_test extends advanced_testcase {
    public function test_is_complete_response() {
        $question = test_question_maker::make_question('calculated');

        $this->assertFalse($question->is_complete_response(array()));
        $this->assertTrue($question->is_complete_response(array('answer' => '0')));
        $this->assertTrue($question->is_complete_response(array('answer' => 0)));
        $this->assertFalse($question->is_complete_response(array('answer' => 'test')));
    }

    public function test_is_gradable_response() {
        $question = test_question_maker::make_question('calculated');

        $this->assertFalse($question->is_gradable_response(array()));
        $this->assertTrue($question->is_gradable_response(array('answer' => '0')));
        $this->assertTrue($question->is_gradable_response(array('answer' => 0)));
        $this->assertTrue($question->is_gradable_response(array('answer' => 'test')));
    }

    public function test_grading() {
        $question = test_question_maker::make_question('calculated');
        $question->start_attempt(new question_attempt_step(), 1);
        $values = $question->vs->get_values();

        $this->assertEquals(array(0, question_state::$gradedwrong),
                $question->grade_response(array('answer' => $values['a'] - $values['b'])));
        $this->assertEquals(array(1, question_state::$gradedright),
                $question->grade_response(array('answer' => $values['a'] + $values['b'])));
    }

    public function test_get_correct_response() {
        // Testing with 3.0 + 0.1416.
        $question = test_question_maker::make_question('calculated');
        $question->start_attempt(new question_attempt_step(), 3);
        $values = $question->vs->get_values();
        $this->assertSame(array('answer' => '3.01' ), $question->get_correct_response());
        foreach ($question->answers as $answer) {
            $answer->correctanswerlength = 2;
            $answer->correctanswerformat = 2;
        }
        $this->assertSame(array('answer' => '3.0' ), $question->get_correct_response());

        // Testing with 1.0 + 5.0.
        $question = test_question_maker::make_question('calculated');
        $question->start_attempt(new question_attempt_step(), 1);
        $values = $question->vs->get_values();
        $this->assertSame(array('answer' => '6.00' ), $question->get_correct_response());

        foreach ($question->answers as $answer) {
            $answer->correctanswerlength = 2;
            $answer->correctanswerformat = 2;
        }
        $this->assertSame(array('answer' => '6.0' ),
                $question->get_correct_response());
        // Testing with 31.0 + 0.01416 .
        $question = test_question_maker::make_question('calculated');
        $question->start_attempt(new question_attempt_step(), 4);
        $values = $question->vs->get_values();
        $this->assertSame(array('answer' => '31.01' ), $question->get_correct_response());

        foreach ($question->answers as $answer) {
            $answer->correctanswerlength = 3;
            $answer->correctanswerformat = 2;
        }
        $this->assertSame(array('answer' => '31.0' ), $question->get_correct_response());

    }

    public function test_get_question_summary() {
        $question = test_question_maker::make_question('calculated');
        $question->start_attempt(new question_attempt_step(), 1);
        $values = $question->vs->get_values();

        $qsummary = $question->get_question_summary();
        $this->assertEquals('What is ' . $values['a'] . ' + ' . $values['b'] . '?', $qsummary);
    }

    public function test_summarise_response() {
        $question = test_question_maker::make_question('calculated');
        $question->start_attempt(new question_attempt_step(), 1);
        $values = $question->vs->get_values();

        $this->assertEquals('3.1', $question->summarise_response(array('answer' => '3.1')));
    }

    public function test_classify_response() {
        $question = test_question_maker::make_question('calculated');
        $question->start_attempt(new question_attempt_step(), 1);
        $values = $question->vs->get_values();

        $this->assertEquals(array(
                new question_classified_response(13, $values['a'] + $values['b'], 1.0)),
                $question->classify_response(array('answer' => $values['a'] + $values['b'])));
        $this->assertEquals(array(
                new question_classified_response(14, $values['a'] - $values['b'], 0.0)),
                $question->classify_response(array('answer' => $values['a'] - $values['b'])));
        $this->assertEquals(array(
                new question_classified_response(17, 7 * $values['a'], 0.0)),
                $question->classify_response(array('answer' => 7 * $values['a'])));
        $this->assertEquals(array(
                question_classified_response::no_response()),
                $question->classify_response(array('answer' => '')));
    }

    public function test_classify_response_no_star() {
        $question = test_question_maker::make_question('calculated');
        unset($question->answers[17]);
        $question->start_attempt(new question_attempt_step(), 1);
        $values = $question->vs->get_values();

        $this->assertEquals(array(
                new question_classified_response(13, $values['a'] + $values['b'], 1.0)),
                $question->classify_response(array('answer' => $values['a'] + $values['b'])));
        $this->assertEquals(array(
                new question_classified_response(14, $values['a'] - $values['b'], 0.0)),
                $question->classify_response(array('answer' => $values['a'] - $values['b'])));
        $this->assertEquals(array(
                new question_classified_response(0, 7 * $values['a'], 0.0)),
                $question->classify_response(array('answer' => 7 * $values['a'])));
        $this->assertEquals(array(
                question_classified_response::no_response()),
                $question->classify_response(array('answer' => '')));
    }

    public function test_get_variants_selection_seed_q_not_synchronised() {
        $question = test_question_maker::make_question('calculated');
        $this->assertEquals($question->stamp, $question->get_variants_selection_seed());
    }

    public function test_get_variants_selection_seed_q_synchronised_datasets_not() {
        $question = test_question_maker::make_question('calculated');
        $question->synchronised = true;
        $this->assertEquals($question->stamp, $question->get_variants_selection_seed());
    }

    public function test_get_variants_selection_seed_q_synchronised() {
        $question = test_question_maker::make_question('calculated');
        $question->synchronised = true;
        $question->datasetloader->set_are_synchronised($question->category, true);
        $this->assertEquals('category' . $question->category,
                $question->get_variants_selection_seed());
    }
}
