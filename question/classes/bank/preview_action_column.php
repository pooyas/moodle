<?php



/**
 * @package    question
 * @subpackage classes
 * @copyright  2015 Pooya Saeedi
*/

namespace core_question\bank;

/**
 * Question bank columns for the preview action icon.
 *
 */
class preview_action_column extends action_column_base {
    public function get_name() {
        return 'previewaction';
    }

    protected function display_content($question, $rowclasses) {
        global $PAGE;
        if (question_has_capability_on($question, 'use')) {
            echo $PAGE->get_renderer('core_question')->question_preview_link(
                    $question->id, $this->qbank->get_most_specific_context(), false);
        }
    }

    public function get_required_fields() {
        return array('q.id');
    }
}
