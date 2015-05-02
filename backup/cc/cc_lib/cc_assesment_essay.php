<?php
/**
 * @package    backup-convert
 * @copyright  2012 Darko Miletic <dmiletic@lionrooms.com>
 * 
 */

defined('LION_INTERNAL') or die('Direct access to this script is forbidden.');

class cc_assesment_question_essay extends cc_assesment_question_proc_base {
    public function __construct($quiz, $questions, $manifest, $section, $question_node, $rootpath, $contextid, $outdir) {
        parent::__construct($quiz, $questions, $manifest, $section, $question_node, $rootpath, $contextid, $outdir);
        $this->qtype = cc_qti_profiletype::essay;
        $maximum_quiz_grade = (int)$this->quiz->nodeValue('/activity/quiz/grade');
        $this->total_grade_value = ($maximum_quiz_grade + 1).'.0000000';
    }

    public function on_generate_metadata() {
        parent::on_generate_metadata();
        // Mark essay for manual grading.
        $this->qmetadata->enable_scoringpermitted();
        $this->qmetadata->enable_computerscored(false);
    }

    public function on_generate_presentation() {
        parent::on_generate_presentation();
        $response_str = new cc_assesment_response_strtype();
        $response_fib = new cc_assesment_render_fibtype();
        $row_value = (int)$this->questions->nodeValue('plugin_qtype_essay_question//responsefieldlines', $this->question_node);
        $response_fib->set_rows($row_value);
        $response_str->set_render_fib($response_fib);
        $this->qpresentation->set_response_str($response_str);
    }

    public function on_generate_response_processing() {
        parent::on_generate_response_processing();

        // Response conditions.
        if (!empty($this->general_feedback)) {
            $qrespcondition = new cc_assesment_respconditiontype();
            $qrespcondition->set_title('General feedback');
            $this->qresprocessing->add_respcondition($qrespcondition);
            // Define the condition for success.
            $qconditionvar = new cc_assignment_conditionvar();
            $qrespcondition->set_conditionvar($qconditionvar);
            $qother = new cc_assignment_conditionvar_othertype();
            $qconditionvar->set_other($qother);
            $qdisplayfeedback = new cc_assignment_displayfeedbacktype();
            $qrespcondition->add_displayfeedback($qdisplayfeedback);
            $qdisplayfeedback->set_feedbacktype(cc_qti_values::Response);
            $qdisplayfeedback->set_linkrefid('general_fb');
        }
    }
}

