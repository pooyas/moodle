<?php


/**
 * This file contains tests that walks a truefalse question through various
 * behaviours.
 *
 * @package    question_type
 * @subpackage truefalse
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');


/**
 * Walkthrough tests for the truefalse question type.
 *
 */
class qtype_truefalse_walkthrough_test extends qbehaviour_walkthrough_test_base {
    public function test_false_right_does_not_show_feedback_when_not_answered() {

        // Create a true-false question with correct answer false.
        $tf = test_question_maker::make_question('truefalse', 'false');
        $this->start_attempt_at_question($tf, 'deferredfeedback', 1);

        // Check the initial state.
        $this->check_current_state(question_state::$todo);
        $this->check_current_mark(null);
        $this->check_current_output(
                $this->get_contains_question_text_expectation($tf),
                $this->get_does_not_contain_feedback_expectation(),
                new question_contains_tag_with_contents('h4',
                        get_string('questiontext', 'question')));
        $this->assertEquals(get_string('false', 'qtype_truefalse'),
                $this->quba->get_right_answer_summary($this->slot));
        $this->assertRegExp('/' . preg_quote($tf->questiontext, '/') . '/',
                $this->quba->get_question_summary($this->slot));
        $this->assertNull($this->quba->get_response_summary($this->slot));

        // Finish the attempt without answering.
        $this->quba->finish_all_questions();

        // Verify.
        $this->check_current_state(question_state::$gaveup);
        $this->check_current_mark(null);
        $this->check_current_output(
                $this->get_contains_tf_true_radio_expectation(false, false),
                $this->get_contains_tf_false_radio_expectation(false, false),

                // In particular, check that the false feedback is not displayed.
                new question_no_pattern_expectation('/' . preg_quote($tf->falsefeedback, '/') . '/'));

    }
}
