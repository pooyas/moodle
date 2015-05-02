<?php

namespace core_question\bank;

/**
 * A column type for the name of the question type.
 *
 * @copyright  2009 Tim Hunt
 * 
 */
class question_type_column extends column_base {
    public function get_name() {
        return 'qtype';
    }

    protected function get_title() {
        return get_string('qtypeveryshort', 'question');
    }

    protected function get_title_tip() {
        return get_string('questiontype', 'question');
    }

    protected function display_content($question, $rowclasses) {
        echo print_question_icon($question);
    }

    public function get_required_fields() {
        return array('q.qtype');
    }

    public function is_sortable() {
        return 'q.qtype';
    }
}
