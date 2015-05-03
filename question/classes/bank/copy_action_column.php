<?php

namespace core_question\bank;

/**
 * Question bank column for the duplicate action icon.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */

class copy_action_column extends action_column_base {
    /** @var string avoids repeated calls to get_string('duplicate'). */
    protected $strcopy;

    public function init() {
        parent::init();
        $this->strcopy = get_string('duplicate');
    }

    public function get_name() {
        return 'copyaction';
    }

    protected function display_content($question, $rowclasses) {
        // To copy a question, you need permission to add a question in the same
        // category as the existing question, and ability to access the details of
        // the question being copied.
        if (question_has_capability_on($question, 'add') &&
                (question_has_capability_on($question, 'edit') || question_has_capability_on($question, 'view'))) {
            $this->print_icon('t/copy', $this->strcopy, $this->qbank->copy_question_url($question->id));
        }
    }
}
