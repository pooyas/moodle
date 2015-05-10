<?php

/**
 * Question behaviour for questions that can only be graded manually.
 *
 * @package    qbehaviour
 * @subpackage manualgraded
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Question behaviour for questions that can only be graded manually.
 *
 * The student enters their response during the attempt, and it is saved. Later,
 * when the whole attempt is finished, the attempt goes into the NEEDS_GRADING
 * state, and the teacher must grade it manually.
 *
 */
class qbehaviour_manualgraded extends question_behaviour_with_save {

    public function is_compatible_question(question_definition $question) {
        return $question instanceof question_with_responses;
    }

    public function adjust_display_options(question_display_options $options) {
        parent::adjust_display_options($options);

        if ($this->qa->get_state()->is_finished()) {
            // Hide all feedback except genfeedback and manualcomment.
            $save = clone($options);
            $options->hide_all_feedback();
            $options->generalfeedback = $save->generalfeedback;
            $options->manualcomment = $save->manualcomment;
        }
    }

    public function process_action(question_attempt_pending_step $pendingstep) {
        if ($pendingstep->has_behaviour_var('comment')) {
            return $this->process_comment($pendingstep);
        } else if ($pendingstep->has_behaviour_var('finish')) {
            return $this->process_finish($pendingstep);
        } else {
            return $this->process_save($pendingstep);
        }
    }

    public function summarise_action(question_attempt_step $step) {
        if ($step->has_behaviour_var('comment')) {
            return $this->summarise_manual_comment($step);
        } else if ($step->has_behaviour_var('finish')) {
            return $this->summarise_finish($step);
        } else {
            return $this->summarise_save($step);
        }
    }

    public function process_finish(question_attempt_pending_step $pendingstep) {
        if ($this->qa->get_state()->is_finished()) {
            return question_attempt::DISCARD;
        }

        $response = $this->qa->get_last_step()->get_qt_data();
        if (!$this->question->is_complete_response($response)) {
            $pendingstep->set_state(question_state::$gaveup);
        } else {
            $pendingstep->set_state(question_state::$needsgrading);
        }
        $pendingstep->set_new_response_summary($this->question->summarise_response($response));
        return question_attempt::KEEP;
    }
}
