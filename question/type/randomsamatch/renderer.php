<?php


/**
 * Matching question renderer class.
 *
 * @package    question_type
 * @subpackage randomsamatch
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/match/renderer.php');

/**
 * Generates the output for randomsamatch questions.
 *
 */
class qtype_randomsamatch_renderer extends qtype_match_renderer {
    public function format_stem_text($qa, $stemid) {
        $question = $qa->get_question();
        return $question->format_text(
                    $question->stems[$stemid], $question->stemformat[$stemid],
                    $qa, 'question', 'questiontext', $stemid);
    }
}
