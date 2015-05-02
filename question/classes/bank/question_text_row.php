<?php


namespace core_question\bank;

/**
 * A column type for the name of the question name.
 *
 * @copyright  2009 Tim Hunt
 * 
 */
class question_text_row extends row_base {
    protected $formatoptions;

    protected function init() {
        $this->formatoptions = new \stdClass();
        $this->formatoptions->noclean = true;
        $this->formatoptions->para = false;
    }

    public function get_name() {
        return 'questiontext';
    }

    protected function get_title() {
        return get_string('questiontext', 'question');
    }

    protected function display_content($question, $rowclasses) {
        $text = question_rewrite_question_preview_urls($question->questiontext, $question->id,
                $question->contextid, 'question', 'questiontext', $question->id,
                $question->contextid, 'core_question');
        $text = format_text($text, $question->questiontextformat,
                $this->formatoptions);
        if ($text == '') {
            $text = '&#160;';
        }
        echo $text;
    }

    public function get_extra_joins() {
        return array('qc' => 'JOIN {question_categories} qc ON qc.id = q.category');
    }

    public function get_required_fields() {
        return array('q.id', 'q.questiontext', 'q.questiontextformat', 'qc.contextid');
    }
}
