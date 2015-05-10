<?php

/**
 * Question type class for the 'missingtype' type.
 *
 * @package    qtype
 * @subpackage missingtype
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Missing question type class
 *
 * When we encounter a question of a type that is not currently installed, then
 * we use this question type class instead so that some of the information about
 * this question can be seen, and the rest of the system keeps working.
 *
 */
class qtype_missingtype extends question_type {
    public function menu_name() {
        return false;
    }

    public function is_usable_by_random() {
        return false;
    }

    public function can_analyse_responses() {
        return false;
    }

    public function make_question($questiondata) {
        $question = parent::make_question($questiondata);
        $question->questiontext = html_writer::tag('div',
                get_string('missingqtypewarning', 'qtype_missingtype'),
                array('class' => 'warning missingqtypewarning')) .
                $question->questiontext;
        return $question;
    }

    public function make_deleted_instance($questionid, $maxmark) {
        question_bank::load_question_definition_classes('missingtype');
        $question = new qtype_missingtype_question();
        $question->id = $questionid;
        $question->category = null;
        $question->parent = 0;
        $question->qtype = question_bank::get_qtype('missingtype');
        $question->name = get_string('deletedquestion', 'qtype_missingtype');
        $question->questiontext = get_string('deletedquestiontext', 'qtype_missingtype');
        $question->questiontextformat = FORMAT_HTML;
        $question->generalfeedback = '';
        $question->defaultmark = $maxmark;
        $question->length = 1;
        $question->penalty = 0;
        $question->stamp = '';
        $question->version = 0;
        $question->hidden = 0;
        $question->timecreated = null;
        $question->timemodified = null;
        $question->createdby = null;
        $question->modifiedby = null;
        return $question;
    }

    public function get_random_guess_score($questiondata) {
        return null;
    }

    public function display_question_editing_page($mform, $question, $wizardnow) {
        global $OUTPUT;
        echo $OUTPUT->heading(get_string('warningmissingtype', 'qtype_missingtype'));

        $mform->display();
    }
}
