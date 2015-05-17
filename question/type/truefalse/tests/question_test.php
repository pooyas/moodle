<?php


/**
 * Unit tests for the true-false question definition class.
 *
 * @package    question_type
 * @subpackage truefalse
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');


/**
 * Unit tests for the true-false question definition class.
 *
 */
class qtype_truefalse_question_test extends advanced_testcase {
    public function test_is_complete_response() {
        $question = test_question_maker::make_question('truefalse', 'true');

        $this->assertFalse($question->is_complete_response(array()));
        $this->assertTrue($question->is_complete_response(array('answer' => 0)));
        $this->assertTrue($question->is_complete_response(array('answer' => 1)));
    }

    public function test_is_gradable_response() {
        $question = test_question_maker::make_question('truefalse', 'true');

        $this->assertFalse($question->is_gradable_response(array()));
        $this->assertTrue($question->is_gradable_response(array('answer' => 0)));
        $this->assertTrue($question->is_gradable_response(array('answer' => 1)));
    }

    public function test_grading() {
        $question = test_question_maker::make_question('truefalse', 'true');

        $this->assertEquals(array(0, question_state::$gradedwrong),
                $question->grade_response(array('answer' => 0)));
        $this->assertEquals(array(1, question_state::$gradedright),
                $question->grade_response(array('answer' => 1)));
    }

    public function test_get_correct_response() {
        $question = test_question_maker::make_question('truefalse', 'true');

        // True.
        $this->assertSame(array('answer' => 1),
                $question->get_correct_response());

        // False.
        $question->rightanswer = false;
        $this->assertSame(array('answer' => 0),
                $question->get_correct_response());
    }

    public function test_get_question_summary() {
        $tf = test_question_maker::make_question('truefalse', 'true');
        $qsummary = $tf->get_question_summary();
        $this->assertEquals('The answer is true.', $qsummary);
    }

    public function test_summarise_response() {
        $tf = test_question_maker::make_question('truefalse', 'true');

        $this->assertEquals(get_string('false', 'qtype_truefalse'),
                $tf->summarise_response(array('answer' => '0')));

        $this->assertEquals(get_string('true', 'qtype_truefalse'),
                $tf->summarise_response(array('answer' => '1')));
    }

    public function test_classify_response() {
        $tf = test_question_maker::make_question('truefalse', 'true');
        $tf->start_attempt(new question_attempt_step(), 1);

        $this->assertEquals(array(
                $tf->id => new question_classified_response(
                        0, get_string('false', 'qtype_truefalse'), 0.0)),
                $tf->classify_response(array('answer' => '0')));
        $this->assertEquals(array(
                $tf->id => new question_classified_response(
                        1, get_string('true', 'qtype_truefalse'), 1.0)),
                $tf->classify_response(array('answer' => '1')));
        $this->assertEquals(array(
                $tf->id => question_classified_response::no_response()),
                $tf->classify_response(array()));
    }
}
