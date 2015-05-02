<?php

namespace core_question\bank;

/**
 * A column type for the name of the question name.
 *
 * @copyright  2009 Tim Hunt
 * 
 */
class question_name_column extends column_base {
    protected $checkboxespresent = null;

    public function get_name() {
        return 'questionname';
    }

    protected function get_title() {
        return get_string('question');
    }

    protected function label_for($question) {
        if (is_null($this->checkboxespresent)) {
            $this->checkboxespresent = $this->qbank->has_column('core_question\bank\checkbox_column');
        }
        if ($this->checkboxespresent) {
            return 'checkq' . $question->id;
        } else {
            return '';
        }
    }

    protected function display_content($question, $rowclasses) {
        $labelfor = $this->label_for($question);
        if ($labelfor) {
            echo '<label for="' . $labelfor . '">';
        }
        echo format_string($question->name);
        if ($labelfor) {
            echo '</label>';
        }
    }

    public function get_required_fields() {
        return array('q.id', 'q.name');
    }

    public function is_sortable() {
        return 'q.name';
    }
}
