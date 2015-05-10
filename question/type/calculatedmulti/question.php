<?php

/**
 * Calculated multiple-choice question definition class.
 *
 * @package    qtype
 * @subpackage calculatedmulti
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/multichoice/question.php');
require_once($CFG->dirroot . '/question/type/calculated/question.php');


/**
 * Represents a calculated multiple-choice multiple-response question.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class qtype_calculatedmulti_single_question extends qtype_multichoice_single_question
        implements qtype_calculated_question_with_expressions {

    /** @var qtype_calculated_dataset_loader helper for loading the dataset. */
    public $datasetloader;

    /** @var qtype_calculated_variable_substituter stores the dataset we are using. */
    public $vs;

    /**
     * @var bool wheter the dataset item to use should be chose based on attempt
     * start time, rather than randomly.
     */
    public $synchronised;

    public function start_attempt(question_attempt_step $step, $variant) {
        qtype_calculated_question_helper::start_attempt($this, $step, $variant);
        parent::start_attempt($step, $variant);
    }

    public function apply_attempt_state(question_attempt_step $step) {
        qtype_calculated_question_helper::apply_attempt_state($this, $step);
        parent::apply_attempt_state($step);
    }

    public function calculate_all_expressions() {
        qtype_calculatedmulti_calculate_helper::calculate_all_expressions($this);
    }

    public function get_num_variants() {
        return $this->datasetloader->get_number_of_items();
    }

    public function get_variants_selection_seed() {
        if (!empty($this->synchronised) &&
                $this->datasetloader->datasets_are_synchronised($this->category)) {
            return 'category' . $this->category;
        } else {
            return parent::get_variants_selection_seed();
        }
    }
}


/**
 * Represents a calculated multiple-choice multiple-response question.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class qtype_calculatedmulti_multi_question extends qtype_multichoice_multi_question
        implements qtype_calculated_question_with_expressions {

    /** @var qtype_calculated_dataset_loader helper for loading the dataset. */
    public $datasetloader;

    /** @var qtype_calculated_variable_substituter stores the dataset we are using. */
    public $vs;

    /**
     * @var bool wheter the dataset item to use should be chose based on attempt
     * start time, rather than randomly.
     */
    public $synchronised;

    public function start_attempt(question_attempt_step $step, $variant) {
        qtype_calculated_question_helper::start_attempt($this, $step, $variant);
        parent::start_attempt($step, $variant);
    }

    public function apply_attempt_state(question_attempt_step $step) {
        qtype_calculated_question_helper::apply_attempt_state($this, $step);
        parent::apply_attempt_state($step);
    }

    public function calculate_all_expressions() {
        qtype_calculatedmulti_calculate_helper::calculate_all_expressions($this);
    }

    public function get_num_variants() {
        return $this->datasetloader->get_number_of_items();
    }

    public function get_variants_selection_seed() {
        if (!empty($this->synchronised) &&
                $this->datasetloader->datasets_are_synchronised($this->category)) {
            return 'category' . $this->category;
        } else {
            return parent::get_variants_selection_seed();
        }
    }
}


/**
 * Helper to abstract common code between qtype_calculatedmulti_single_question
 * and qtype_calculatedmulti_multi_question.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
abstract class qtype_calculatedmulti_calculate_helper {
    /**
     * Calculate all the exressions in a qtype_calculatedmulti_single_question
     * or qtype_calculatedmulti_multi_question.
     * @param unknown_type $question
     */
    public static function calculate_all_expressions(
            qtype_calculated_question_with_expressions $question) {
        $question->questiontext = $question->vs->replace_expressions_in_text(
                $question->questiontext);
        $question->generalfeedback = $question->vs->replace_expressions_in_text(
                $question->generalfeedback);

        foreach ($question->answers as $ans) {
            if ($ans->answer && $ans->answer !== '*') {
                $ans->answer = $question->vs->replace_expressions_in_text($ans->answer,
                        $ans->correctanswerlength, $ans->correctanswerformat);
            }
            $ans->feedback = $question->vs->replace_expressions_in_text($ans->feedback,
                    $ans->correctanswerlength, $ans->correctanswerformat);
        }
    }
}