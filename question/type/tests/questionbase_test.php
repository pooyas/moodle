<?php

/**
 * Unit tests for the question definition base classes.
 *
 * @package    core
 * @subpackage questiontypes
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/type/questiontypebase.php');


/**
 * Unit tests for the question definition base classes.
 *
 */
class test_response_answer_comparer implements question_response_answer_comparer {
    protected $answers = array();

    public function __construct($answers) {
        $this->answers = $answers;
    }

    public function get_answers() {
        return $this->answers;
    }

    public function compare_response_with_answer(array $response, question_answer $answer) {
        return $response['answer'] == $answer->answer;
    }
}

/**
 * Tests for {@link question_first_matching_answer_grading_strategy}.
 *
 */
class question_first_matching_answer_grading_strategy_test extends advanced_testcase {
    protected function setUp() {
    }

    protected function tearDown() {
    }

    public function test_no_answers_gives_null() {
        $question = new test_response_answer_comparer(array());
        $strategy = new question_first_matching_answer_grading_strategy($question);
        $this->assertNull($strategy->grade(array()));
    }

    public function test_matching_answer_returned1() {
        $answer = new question_answer(0, 'frog', 1, '', FORMAT_HTML);
        $question = new test_response_answer_comparer(array($answer));
        $strategy = new question_first_matching_answer_grading_strategy($question);
        $this->assertSame($answer, $strategy->grade(array('answer' => 'frog')));
    }

    public function test_matching_answer_returned2() {
        $answer = new question_answer(0, 'frog', 1, '', FORMAT_HTML);
        $answer2 = new question_answer(0, 'frog', 0.5, '', FORMAT_HTML);
        $question = new test_response_answer_comparer(array($answer, $answer2));
        $strategy = new question_first_matching_answer_grading_strategy($question);
        $this->assertSame($answer, $strategy->grade(array('answer' => 'frog')));
    }

    public function test_no_matching_answer_gives_null() {
        $answer = new question_answer(0, 'frog', 1, '', FORMAT_HTML);
        $answer2 = new question_answer(0, 'frog', 0.5, '', FORMAT_HTML);
        $question = new test_response_answer_comparer(array($answer, $answer2));
        $strategy = new question_first_matching_answer_grading_strategy($question);
        $this->assertNull($strategy->grade(array('answer' => 'toad')));
    }
}


/**
 * Test for question_hint and subclasses.
 *
 */
class question_hint_test extends advanced_testcase {
    public function test_basic() {
        $row = new stdClass();
        $row->id = 123;
        $row->hint = 'A hint';
        $row->hintformat = FORMAT_HTML;
        $hint = question_hint::load_from_record($row);
        $this->assertEquals($row->id, $hint->id);
        $this->assertEquals($row->hint, $hint->hint);
        $this->assertEquals($row->hintformat, $hint->hintformat);
    }

    public function test_with_parts() {
        $row = new stdClass();
        $row->id = 123;
        $row->hint = 'A hint';
        $row->hintformat = FORMAT_HTML;
        $row->shownumcorrect = 1;
        $row->clearwrong = 1;

        $hint = question_hint_with_parts::load_from_record($row);
        $this->assertEquals($row->id, $hint->id);
        $this->assertEquals($row->hint, $hint->hint);
        $this->assertEquals($row->hintformat, $hint->hintformat);
        $this->assertNotEmpty($hint->shownumcorrect);
        $this->assertNotEmpty($hint->clearwrong);
    }
}
