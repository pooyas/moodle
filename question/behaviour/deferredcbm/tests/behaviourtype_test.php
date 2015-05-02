<?php

/**
 * This file contains tests that walks a question through the deferred feedback
 * with certainty base marking behaviour.
 *
 * @package    qbehaviour
 * @subpackage deferredcbm
 * @copyright  2009 The Open University
 * 
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once(dirname(__FILE__) . '/../../../engine/lib.php');
require_once(dirname(__FILE__) . '/../../../engine/tests/helpers.php');


/**
 * Unit tests for the deferred feedback with certainty base marking behaviour.
 *
 * @copyright  2009 The Open University
 * 
 */
class qbehaviour_deferredcbm_type_test extends qbehaviour_walkthrough_test_base {

    /** @var qbehaviour_deferredcbm_type */
    protected $behaviourtype;

    public function setUp() {
        parent::setUp();
        $this->behaviourtype = question_engine::get_behaviour_type('deferredcbm');
    }

    public function test_is_archetypal() {
        $this->assertTrue($this->behaviourtype->is_archetypal());
    }

    public function test_get_unused_display_options() {
        $this->assertEquals(array('correctness', 'marks', 'specificfeedback', 'generalfeedback', 'rightanswer'),
                $this->behaviourtype->get_unused_display_options());
    }

    public function test_adjust_random_guess_score() {
        $this->assertEquals(0, $this->behaviourtype->adjust_random_guess_score(0));
        $this->assertEquals(1, $this->behaviourtype->adjust_random_guess_score(1));
    }

    public function test_summarise_usage_max_mark_1() {

        // Create a usage comprising 3 true-false questions.
        $this->quba->set_preferred_behaviour('deferredcbm');
        $this->quba->add_question(test_question_maker::make_question('truefalse', 'true'), 3);
        $this->quba->add_question(test_question_maker::make_question('truefalse', 'true'), 3);
        $this->quba->add_question(test_question_maker::make_question('truefalse', 'true'), 3);
        $this->quba->start_all_questions();

        // Process responses right, high certainty; right, med certainty; wrong, med certainty.
        $this->quba->process_action(1, array('answer' => 1, '-certainty' => 3));
        $this->quba->process_action(2, array('answer' => 1, '-certainty' => 2));
        $this->quba->process_action(3, array('answer' => 0, '-certainty' => 2));
        $this->quba->finish_all_questions();

        // Get the summary.
        $summarydata = $this->quba->get_summary_information(new question_display_options());

        // Verify.
        $this->assertContains(get_string('breakdownbycertainty', 'qbehaviour_deferredcbm'),
                $summarydata['qbehaviour_cbm_judgement_heading']['content']);

        $this->assertContains('100%',
                $summarydata['qbehaviour_cbm_judgement3']['content']);
        $this->assertContains(get_string('judgementok', 'qbehaviour_deferredcbm'),
                $summarydata['qbehaviour_cbm_judgement3']['content']);

        $this->assertContains('50%',
                $summarydata['qbehaviour_cbm_judgement2']['content']);
        $this->assertContains(get_string('slightlyoverconfident', 'qbehaviour_deferredcbm'),
                $summarydata['qbehaviour_cbm_judgement2']['content']);

        $this->assertContains(get_string('noquestions', 'qbehaviour_deferredcbm'),
                $summarydata['qbehaviour_cbm_judgement1']['content']);
    }

    public function test_summarise_usage_max_mark_3() {

        // Create a usage comprising 3 true-false questions.
        $this->quba->set_preferred_behaviour('deferredcbm');
        $this->quba->add_question(test_question_maker::make_question('truefalse', 'true'), 1);
        $this->quba->add_question(test_question_maker::make_question('truefalse', 'true'), 1);
        $this->quba->add_question(test_question_maker::make_question('truefalse', 'true'), 1);
        $this->quba->start_all_questions();

        // Process responses right, high certainty; right, med certainty; wrong, med certainty.
        $this->quba->process_action(1, array('answer' => 1, '-certainty' => 3));
        $this->quba->process_action(2, array('answer' => 1, '-certainty' => 2));
        $this->quba->process_action(3, array('answer' => 0, '-certainty' => 2));
        $this->quba->finish_all_questions();

        // Get the summary.
        $summarydata = $this->quba->get_summary_information(new question_display_options());

        // Verify.
        $this->assertContains(get_string('breakdownbycertainty', 'qbehaviour_deferredcbm'),
                $summarydata['qbehaviour_cbm_judgement_heading']['content']);

        $this->assertContains('100%',
                $summarydata['qbehaviour_cbm_judgement3']['content']);
        $this->assertContains(get_string('judgementok', 'qbehaviour_deferredcbm'),
                $summarydata['qbehaviour_cbm_judgement3']['content']);

        $this->assertContains('50%',
                $summarydata['qbehaviour_cbm_judgement2']['content']);
        $this->assertContains(get_string('slightlyoverconfident', 'qbehaviour_deferredcbm'),
                $summarydata['qbehaviour_cbm_judgement2']['content']);

        $this->assertContains(get_string('noquestions', 'qbehaviour_deferredcbm'),
                $summarydata['qbehaviour_cbm_judgement1']['content']);
    }

    public function test_calculate_bonus() {
        $this->assertEquals(0.05,  $this->behaviourtype->calculate_bonus(1, 1/2));
        $this->assertEquals(-0.01, $this->behaviourtype->calculate_bonus(2, 9/10));
        $this->assertEquals(0,     $this->behaviourtype->calculate_bonus(3, 1));
    }
}
