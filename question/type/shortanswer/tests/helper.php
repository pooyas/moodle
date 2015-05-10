<?php

/**
 * Test helpers for the shortanswer question type.
 *
 * @package    qtype
 * @subpackage shortanswer
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Test helper class for the shortanswer question type.
 *
 */
class qtype_shortanswer_test_helper extends question_test_helper {
    public function get_test_questions() {
        return array('frogtoad', 'frogonly', 'escapedwildcards');
    }

    /**
     * Makes a shortanswer question with correct ansewer 'frog', partially
     * correct answer 'toad' and defaultmark 1. This question also has a
     * '*' match anything answer.
     * @return qtype_shortanswer_question
     */
    public function make_shortanswer_question_frogtoad() {
        question_bank::load_question_definition_classes('shortanswer');
        $sa = new qtype_shortanswer_question();
        test_question_maker::initialise_a_question($sa);
        $sa->name = 'Short answer question';
        $sa->questiontext = 'Name an amphibian: __________';
        $sa->generalfeedback = 'Generalfeedback: frog or toad would have been OK.';
        $sa->usecase = false;
        $sa->answers = array(
            13 => new question_answer(13, 'frog', 1.0, 'Frog is a very good answer.', FORMAT_HTML),
            14 => new question_answer(14, 'toad', 0.8, 'Toad is an OK good answer.', FORMAT_HTML),
            15 => new question_answer(15, '*', 0.0, 'That is a bad answer.', FORMAT_HTML),
        );
        $sa->qtype = question_bank::get_qtype('shortanswer');

        return $sa;
    }

    /**
     * Gets the question data for a shortanswer question with with correct
     * ansewer 'frog', partially correct answer 'toad' and defaultmark 1.
     * This question also has a '*' match anything answer.
     * @return stdClass
     */
    public function get_shortanswer_question_data_frogtoad() {
        $qdata = new stdClass();
        test_question_maker::initialise_question_data($qdata);

        $qdata->qtype = 'shortanswer';
        $qdata->name = 'Short answer question';
        $qdata->questiontext = 'Name an amphibian: __________';
        $qdata->generalfeedback = 'Generalfeedback: frog or toad would have been OK.';

        $qdata->options = new stdClass();
        $qdata->options->usecase = 0;
        $qdata->options->answers = array(
            13 => new question_answer(13, 'frog', 1.0, 'Frog is a very good answer.', FORMAT_HTML),
            14 => new question_answer(14, 'toad', 0.8, 'Toad is an OK good answer.', FORMAT_HTML),
            15 => new question_answer(15, '*', 0.0, 'That is a bad answer.', FORMAT_HTML),
        );

        return $qdata;
    }

    /**
     * Gets the question form data for a shortanswer question with with correct
     * answer 'frog', partially correct answer 'toad' and defaultmark 1.
     * This question also has a '*' match anything answer.
     * @return stdClass
     */
    public function get_shortanswer_question_form_data_frogtoad() {
        $form = new stdClass();

        $form->name = 'Short answer question';
        $form->questiontext = array('text' => 'Name an amphibian: __________', 'format' => FORMAT_HTML);
        $form->defaultmark = 1.0;
        $form->generalfeedback = array('text' => 'Generalfeedback: frog or toad would have been OK.', 'format' => FORMAT_HTML);
        $form->usecase = false;
        $form->answer = array('frog', 'toad', '*');
        $form->fraction = array('1.0', '0.8', '0.0');
        $form->feedback = array(
            array('text' => 'Frog is a very good answer.', 'format' => FORMAT_HTML),
            array('text' => 'Toad is an OK good answer.', 'format' => FORMAT_HTML),
            array('text' => 'That is a bad answer.', 'format' => FORMAT_HTML),
        );

        return $form;
    }

    /**
     * Makes a shortanswer question with just the correct ansewer 'frog', and
     * no other answer matching.
     * @return qtype_shortanswer_question
     */
    public function make_shortanswer_question_frogonly() {
        question_bank::load_question_definition_classes('shortanswer');
        $sa = new qtype_shortanswer_question();
        test_question_maker::initialise_a_question($sa);
        $sa->name = 'Short answer question';
        $sa->questiontext = 'Name the best amphibian: __________';
        $sa->generalfeedback = 'Generalfeedback: you should have said frog.';
        $sa->usecase = false;
        $sa->answers = array(
            13 => new question_answer(13, 'frog', 1.0, 'Frog is right.', FORMAT_HTML),
        );
        $sa->qtype = question_bank::get_qtype('shortanswer');

        return $sa;
    }

    /**
     * Gets the question data for a shortanswer questionwith just the correct
     * ansewer 'frog', and no other answer matching.
     * @return stdClass
     */
    public function get_shortanswer_question_data_frogonly() {
        $qdata = new stdClass();
        test_question_maker::initialise_question_data($qdata);

        $qdata->qtype = 'shortanswer';
        $qdata->name = 'Short answer question';
        $qdata->questiontext = 'Name the best amphibian: __________';
        $qdata->generalfeedback = 'Generalfeedback: you should have said frog.';

        $qdata->options = new stdClass();
        $qdata->options->usecase = false;
        $qdata->options->answers = array(
            13 => new question_answer(13, 'frog', 1.0, 'Frog is right.', FORMAT_HTML),
        );

        return $qdata;
    }

    /**
     * Makes a shortanswer question with just the correct ansewer 'frog', and
     * no other answer matching.
     * @return qtype_shortanswer_question
     */
    public function make_shortanswer_question_escapedwildcards() {
        question_bank::load_question_definition_classes('shortanswer');
        $sa = new qtype_shortanswer_question();
        test_question_maker::initialise_a_question($sa);
        $sa->name = 'Question with escaped * in the answer.';
        $sa->questiontext = 'How to you write x times y in C? __________';
        $sa->generalfeedback = 'In C, this expression is written x * y.';
        $sa->usecase = false;
        $sa->answers = array(
            13 => new question_answer(13, '*x\*y*', 1.0, 'Well done.', FORMAT_HTML),
        );
        $sa->qtype = question_bank::get_qtype('shortanswer');

        return $sa;
    }
}
