<?php

namespace core_question\bank;

/**
 * Base class for question bank columns that just contain an action icon.
 *
 * @copyright  2009 Tim Hunt
 * 
 */
class edit_action_column extends action_column_base {
    protected $stredit;
    protected $strview;

    public function init() {
        parent::init();
        $this->stredit = get_string('edit');
        $this->strview = get_string('view');
    }

    public function get_name() {
        return 'editaction';
    }

    protected function display_content($question, $rowclasses) {
        if (question_has_capability_on($question, 'edit')) {
            $this->print_icon('t/edit', $this->stredit, $this->qbank->edit_question_url($question->id));
        } else if (question_has_capability_on($question, 'view')) {
            $this->print_icon('i/info', $this->strview, $this->qbank->edit_question_url($question->id));
        }
    }
}
