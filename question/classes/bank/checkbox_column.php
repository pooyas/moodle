<?php

namespace core_question\bank;

/**
 * A column with a checkbox for each question with name q{questionid}.
 *
 * @copyright  2009 Tim Hunt
 * 
 */
class checkbox_column extends column_base {
    protected $strselect;

    public function init() {
        $this->strselect = get_string('select');
    }

    public function get_name() {
        return 'checkbox';
    }

    protected function get_title() {
        return '<input type="checkbox" disabled="disabled" id="qbheadercheckbox" />';
    }

    protected function get_title_tip() {
        global $PAGE;
        $PAGE->requires->strings_for_js(array('selectall', 'deselectall'), 'lion');
        $PAGE->requires->yui_module('lion-question-qbankmanager', 'M.question.qbankmanager.init');
        return get_string('selectquestionsforbulk', 'question');

    }

    protected function display_content($question, $rowclasses) {
        global $PAGE;
        echo '<input title="' . $this->strselect . '" type="checkbox" name="q' .
                $question->id . '" id="checkq' . $question->id . '" value="1"/>';
    }

    public function get_required_fields() {
        return array('q.id');
    }
}
