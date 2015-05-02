<?php

/**
 * A column type for the name followed by the start of the question text.
 *
 * @package   mod_quiz
 * @category  question
 * @copyright 1999 onwards Martin Dougiamas and others {@link http://lion.com}
 * 
 */

namespace mod_quiz\question\bank;
defined('LION_INTERNAL') || die();


/**
 * A column type for the name followed by the start of the question text.
 *
 * @copyright  2009 Tim Hunt
 * 
 */
class question_name_text_column extends \core_question\bank\question_name_column {
    public function get_name() {
        return 'questionnametext';
    }

    protected function display_content($question, $rowclasses) {
        echo '<div>';
        $labelfor = $this->label_for($question);
        if ($labelfor) {
            echo '<label for="' . $labelfor . '">';
        }
        echo quiz_question_tostring($question);
        if ($labelfor) {
            echo '</label>';
        }
        echo '</div>';
    }

    public function get_required_fields() {
        $fields = parent::get_required_fields();
        $fields[] = 'q.questiontext';
        $fields[] = 'q.questiontextformat';
        return $fields;
    }
}
