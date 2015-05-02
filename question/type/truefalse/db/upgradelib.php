<?php

/**
 * Upgrade library code for the truefalse question type.
 *
 * @package    qtype
 * @subpackage truefalse
 * @copyright  2010 The Open University
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Class for converting attempt data for truefalse questions when upgrading
 * attempts to the new question engine.
 *
 * This class is used by the code in question/engine/upgrade/upgradelib.php.
 *
 * @copyright  2010 The Open University
 * 
 */
class qtype_truefalse_qe2_attempt_updater extends question_qtype_attempt_updater {
    public function right_answer() {
        foreach ($this->question->options->answers as $ans) {
            if ($ans->fraction > 0.999) {
                return $ans->answer;
            }
        }
    }

    public function response_summary($state) {
        if (is_numeric($state->answer)) {
            if (array_key_exists($state->answer, $this->question->options->answers)) {
                return $this->question->options->answers[$state->answer]->answer;
            } else {
                $this->logger->log_assumption("Dealing with a place where the
                        student selected a choice that was later deleted for
                        true/false question {$this->question->id}");
                return null;
            }
        } else {
            return null;
        }
    }

    public function was_answered($state) {
        return !empty($state->answer);
    }

    public function set_first_step_data_elements($state, &$data) {
    }

    public function supply_missing_first_step_data(&$data) {
    }

    public function set_data_elements_for_step($state, &$data) {
        if (is_numeric($state->answer)) {
            $data['answer'] = (int) ($state->answer == $this->question->options->trueanswer);
        }
    }
}
