<?php


/**
 * Embedded answer (Cloze) question importer.
 *
 * @package    question_format
 * @subpackage multianswer
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();


/**
 * Importer that imports a text file containing a single Multianswer question
 * from a text file.
 *
 */
class qformat_multianswer extends qformat_default {

    public function provide_import() {
        return true;
    }

    public function readquestions($lines) {
        question_bank::get_qtype('multianswer'); // Ensure the multianswer code is loaded.

        // For this class the method has been simplified as
        // there can never be more than one question for a
        // multianswer import.
        $questions = array();

        $questiontext = array();
        $questiontext['text'] = implode('', $lines);
        $questiontext['format'] = FORMAT_LION;
        $questiontext['itemid'] = '';
        $question = qtype_multianswer_extract_question($questiontext);
        $question->questiontext = $question->questiontext['text'];
        $question->questiontextformat = 0;

        $question->qtype = 'multianswer';
        $question->generalfeedback = '';
        $question->generalfeedbackformat = FORMAT_LION;
        $question->length = 1;
        $question->penalty = 0.3333333;

        if (!empty($question)) {
            $question->name = $this->create_default_question_name($question->questiontext, get_string('questionname', 'question'));
            $questions[] = $question;
        }

        return $questions;
    }
}
