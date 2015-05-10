<?php

/**
 * Unit tests for the Lion GIFT format.
 *
 * @package    qformat
 * @subpackage gift
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/questionlib.php');
require_once($CFG->dirroot . '/question/format.php');
require_once($CFG->dirroot . '/question/format/gift/format.php');
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');


/**
 * Unit tests for the GIFT import/export format.
 *
 */
class qformat_gift_test extends question_testcase {
    public function assert_same_gift($expectedtext, $text) {
        $this->assertEquals(str_replace("\r\n", "\n", $expectedtext),
                str_replace("\r\n", "\n", $text));
    }

    public function test_import_essay() {
        $gift = '
// essay
::Q8:: How are you? {}';
        $lines = preg_split('/[\\n\\r]/', str_replace("\r\n", "\n", $gift));

        $importer = new qformat_gift();
        $q = $importer->readquestion($lines);

        $expectedq = (object) array(
            'name' => 'Q8',
            'questiontext' => 'How are you?',
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_LION,
            'qtype' => 'essay',
            'defaultmark' => 1,
            'penalty' => 0.3333333,
            'length' => 1,
            'responseformat' => 'editor',
            'responsefieldlines' => 15,
            'attachments' => 0,
            'graderinfo' => array(
                'text' => '',
                'format' => FORMAT_HTML,
                'files' => array()),
        );

        $this->assert(new question_check_specified_fields_expectation($expectedq), $q);
    }

    public function test_export_essay() {
        $qdata = (object) array(
            'id' => 666 ,
            'name' => 'Q8',
            'questiontext' => 'How are you?',
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_LION,
            'defaultmark' => 1,
            'penalty' => 0.3333333,
            'length' => 1,
            'qtype' => 'essay',
            'options' => (object) array(
                'responseformat' => 'editor',
                'responsefieldlines' => 15,
                'attachments' => 0,
                'graderinfo' => '',
                'graderinfoformat' => FORMAT_HTML,
            ),
        );

        $exporter = new qformat_gift();
        $gift = $exporter->writequestion($qdata);

        $expectedgift = "// question: 666  name: Q8
::Q8::How are you?{}

";

        $this->assert_same_gift($expectedgift, $gift);
    }

    public function test_import_match() {
        $gift = '
// question: 2  name: Lion activities
::Lion activities::[html]Match the <b>activity</b> to the description.{
    =[html]An activity supporting asynchronous discussions. -> Forum
    =[lion]A teacher asks a question and specifies a choice of multiple responses. -> Choice
    =[plain]A bank of record entries which participants can add to. -> Database
    =[markdown]A collection of web pages that anyone can add to or edit. -> Wiki
    = -> Chat
}';
        $lines = preg_split('/[\\n\\r]/', str_replace("\r\n", "\n", $gift));

        $importer = new qformat_gift();
        $q = $importer->readquestion($lines);

        $expectedq = (object) array(
            'name' => 'Lion activities',
            'questiontext' => 'Match the <b>activity</b> to the description.',
            'questiontextformat' => FORMAT_HTML,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_HTML,
            'qtype' => 'match',
            'defaultmark' => 1,
            'penalty' => 0.3333333,
            'length' => 1,
            'shuffleanswers' => '1',
            'correctfeedback' => array(
                'text' => '',
                'format' => FORMAT_HTML,
                'files' => array(),
            ),
            'partiallycorrectfeedback' => array(
                'text' => '',
                'format' => FORMAT_HTML,
                'files' => array(),
            ),
            'incorrectfeedback' => array(
                'text' => '',
                'format' => FORMAT_HTML,
                'files' => array(),
            ),
            'subquestions' => array(
                0 => array(
                    'text' => 'An activity supporting asynchronous discussions.',
                    'format' => FORMAT_HTML,
                    'files' => array(),
                ),
                1 => array(
                    'text' => 'A teacher asks a question and specifies a choice of multiple responses.',
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
                2 => array(
                    'text' => 'A bank of record entries which participants can add to.',
                    'format' => FORMAT_PLAIN,
                    'files' => array(),
                ),
                3 => array(
                    'text' => 'A collection of web pages that anyone can add to or edit.',
                    'format' => FORMAT_MARKDOWN,
                    'files' => array(),
                ),
                4 => array(
                    'text' => '',
                    'format' => FORMAT_HTML,
                    'files' => array(),
                ),
            ),
            'subanswers' => array(
                0 => 'Forum',
                1 => 'Choice',
                2 => 'Database',
                3 => 'Wiki',
                4 => 'Chat',
            ),
        );

        // Repeated test for better failure messages.
        $this->assertEquals($expectedq->subquestions, $q->subquestions);
        $this->assert(new question_check_specified_fields_expectation($expectedq), $q);
    }

    public function test_export_match() {
        $qdata = (object) array(
            'id' => 666 ,
            'name' => 'Lion activities',
            'questiontext' => 'Match the <b>activity</b> to the description.',
            'questiontextformat' => FORMAT_HTML,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_HTML,
            'defaultmark' => 1,
            'penalty' => 0.3333333,
            'length' => 1,
            'qtype' => 'match',
            'options' => (object) array(
                'id' => 123,
                'question' => 666,
                'shuffleanswers' => 1,
                'subquestions' => array(
                    42 => (object) array(
                        'id' => 1234,
                        'code' => 12341234,
                        'question' => 666,
                        'questiontext' => '<div class="frog">An activity supporting asynchronous discussions.</div>',
                        'questiontextformat' => FORMAT_HTML,
                        'answertext' => 'Forum',
                    ),
                    43 => (object) array(
                        'id' => 1234,
                        'code' => 12341234,
                        'question' => 666,
                        'questiontext' => 'A teacher asks a question and specifies a choice of multiple responses.',
                        'questiontextformat' => FORMAT_LION,
                        'answertext' => 'Choice',
                    ),
                    44 => (object) array(
                        'id' => 1234,
                        'code' => 12341234,
                        'question' => 666,
                        'questiontext' => 'A bank of record entries which participants can add to.',
                        'questiontextformat' => FORMAT_PLAIN,
                        'answertext' => 'Database',
                    ),
                    45 => (object) array(
                        'id' => 1234,
                        'code' => 12341234,
                        'question' => 666,
                        'questiontext' => 'A collection of web pages that anyone can add to or edit.',
                        'questiontextformat' => FORMAT_MARKDOWN,
                        'answertext' => 'Wiki',
                    ),
                    46 => (object) array(
                        'id' => 1234,
                        'code' => 12341234,
                        'question' => 666,
                        'questiontext' => '',
                        'questiontextformat' => FORMAT_MARKDOWN,
                        'answertext' => 'Chat',
                    ),
                ),
            ),
        );

        $exporter = new qformat_gift();
        $gift = $exporter->writequestion($qdata);

        $expectedgift = "// question: 666  name: Lion activities
::Lion activities::[html]Match the <b>activity</b> to the description.{
\t=<div class\\=\"frog\">An activity supporting asynchronous discussions.</div> -> Forum
\t=[lion]A teacher asks a question and specifies a choice of multiple responses. -> Choice
\t=[plain]A bank of record entries which participants can add to. -> Database
\t=[markdown]A collection of web pages that anyone can add to or edit. -> Wiki
\t= -> Chat
}

";

        $this->assert_same_gift($expectedgift, $gift);
    }

    public function test_import_multichoice() {
        $gift = "
// multiple choice with specified feedback for right and wrong answers
::Q2:: What's between orange and green in the spectrum?
{
    =yellow # right; good!
    ~red # [html]wrong, it's yellow
    ~[plain]blue # wrong, it's yellow
}";
        $lines = preg_split('/[\\n\\r]/', str_replace("\r\n", "\n", $gift));

        $importer = new qformat_gift();
        $q = $importer->readquestion($lines);

        $expectedq = (object) array(
            'name' => 'Q2',
            'questiontext' => "What's between orange and green in the spectrum?",
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_LION,
            'qtype' => 'multichoice',
            'defaultmark' => 1,
            'penalty' => 0.3333333,
            'length' => 1,
            'single' => 1,
            'shuffleanswers' => '1',
            'answernumbering' => 'abc',
            'correctfeedback' => array(
                'text' => '',
                'format' => FORMAT_LION,
                'files' => array(),
            ),
            'partiallycorrectfeedback' => array(
                'text' => '',
                'format' => FORMAT_LION,
                'files' => array(),
            ),
            'incorrectfeedback' => array(
                'text' => '',
                'format' => FORMAT_LION,
                'files' => array(),
            ),
            'answer' => array(
                0 => array(
                    'text' => 'yellow',
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
                1 => array(
                    'text' => 'red',
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
                2 => array(
                    'text' => 'blue',
                    'format' => FORMAT_PLAIN,
                    'files' => array(),
                ),
            ),
            'fraction' => array(1, 0, 0),
            'feedback' => array(
                0 => array(
                    'text' => 'right; good!',
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
                1 => array(
                    'text' => "wrong, it's yellow",
                    'format' => FORMAT_HTML,
                    'files' => array(),
                ),
                2 => array(
                    'text' => "wrong, it's yellow",
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
            ),
        );

        // Repeated test for better failure messages.
        $this->assertEquals($expectedq->answer, $q->answer);
        $this->assertEquals($expectedq->feedback, $q->feedback);
        $this->assert(new question_check_specified_fields_expectation($expectedq), $q);
    }

    public function test_import_multichoice_multi() {
        $gift = "
// multiple choice, multiple response with specified feedback for right and wrong answers
::colours:: What's between orange and green in the spectrum?
{
    ~%50%yellow # right; good!
    ~%-100%red # [html]wrong
    ~%50%off-beige # right; good!
    ~%-100%[plain]blue # wrong
}";
        $lines = preg_split('/[\\n\\r]/', str_replace("\r\n", "\n", $gift));

        $importer = new qformat_gift();
        $q = $importer->readquestion($lines);

        $expectedq = (object) array(
            'name' => 'colours',
            'questiontext' => "What's between orange and green in the spectrum?",
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_LION,
            'qtype' => 'multichoice',
            'defaultmark' => 1,
            'penalty' => 0.3333333,
            'length' => 1,
            'single' => 0,
            'shuffleanswers' => '1',
            'answernumbering' => 'abc',
            'correctfeedback' => array(
                'text' => '',
                'format' => FORMAT_LION,
                'files' => array(),
            ),
            'partiallycorrectfeedback' => array(
                'text' => '',
                'format' => FORMAT_LION,
                'files' => array(),
            ),
            'incorrectfeedback' => array(
                'text' => '',
                'format' => FORMAT_LION,
                'files' => array(),
            ),
            'answer' => array(
                0 => array(
                    'text' => 'yellow',
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
                1 => array(
                    'text' => 'red',
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
                2 => array(
                    'text' => 'off-beige',
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
                3 => array(
                    'text' => 'blue',
                    'format' => FORMAT_PLAIN,
                    'files' => array(),
                ),
            ),
            'fraction' => array(0.5, -1, 0.5, -1),
            'feedback' => array(
                0 => array(
                    'text' => 'right; good!',
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
                1 => array(
                    'text' => "wrong",
                    'format' => FORMAT_HTML,
                    'files' => array(),
                ),
                2 => array(
                    'text' => "right; good!",
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
                3 => array(
                    'text' => "wrong",
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
            ),
        );

        // Repeated test for better failure messages.
        $this->assertEquals($expectedq->answer, $q->answer);
        $this->assertEquals($expectedq->feedback, $q->feedback);
        $this->assert(new question_check_specified_fields_expectation($expectedq), $q);
    }

    public function test_export_multichoice() {
        $qdata = (object) array(
            'id' => 666 ,
            'name' => 'Q8',
            'questiontext' => "What's between orange and green in the spectrum?",
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_LION,
            'defaultmark' => 1,
            'penalty' => 0.3333333,
            'length' => 1,
            'qtype' => 'multichoice',
            'options' => (object) array(
                'single' => 1,
                'shuffleanswers' => '1',
                'answernumbering' => 'abc',
                'correctfeedback' => '',
                'correctfeedbackformat' => FORMAT_LION,
                'partiallycorrectfeedback' => '',
                'partiallycorrectfeedbackformat' => FORMAT_LION,
                'incorrectfeedback' => '',
                'incorrectfeedbackformat' => FORMAT_LION,
                'answers' => array(
                    123 => (object) array(
                        'id' => 123,
                        'answer' => 'yellow',
                        'answerformat' => FORMAT_LION,
                        'fraction' => 1,
                        'feedback' => 'right; good!',
                        'feedbackformat' => FORMAT_LION,
                    ),
                    124 => (object) array(
                        'id' => 124,
                        'answer' => 'red',
                        'answerformat' => FORMAT_LION,
                        'fraction' => 0,
                        'feedback' => "wrong, it's yellow",
                        'feedbackformat' => FORMAT_HTML,
                    ),
                    125 => (object) array(
                        'id' => 125,
                        'answer' => 'blue',
                        'answerformat' => FORMAT_PLAIN,
                        'fraction' => 0,
                        'feedback' => "wrong, it's yellow",
                        'feedbackformat' => FORMAT_LION,
                    ),
                ),
            ),
        );

        $exporter = new qformat_gift();
        $gift = $exporter->writequestion($qdata);

        $expectedgift = "// question: 666  name: Q8
::Q8::What's between orange and green in the spectrum?{
\t=yellow#right; good!
\t~red#[html]wrong, it's yellow
\t~[plain]blue#wrong, it's yellow
}

";

        $this->assert_same_gift($expectedgift, $gift);
    }

    public function test_import_numerical() {
        $gift = "
// math range question
::Q5:: What is a number from 1 to 5? {#3:2~#Completely wrong}";
        $lines = preg_split('/[\\n\\r]/', str_replace("\r\n", "\n", $gift));

        $importer = new qformat_gift();
        $q = $importer->readquestion($lines);

        $expectedq = (object) array(
            'name' => 'Q5',
            'questiontext' => "What is a number from 1 to 5?",
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_LION,
            'qtype' => 'numerical',
            'defaultmark' => 1,
            'penalty' => 0.3333333,
            'length' => 1,
            'answer' => array(
                '3',
                '*',
            ),
            'fraction' => array(1, 0),
            'feedback' => array(
                0 => array(
                    'text' => '',
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
                1 => array(
                    'text' => "Completely wrong",
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
            ),
            'tolerance' => array(2, 0),
        );

        // Repeated test for better failure messages.
        $this->assertEquals($expectedq->answer, $q->answer);
        $this->assertEquals($expectedq->fraction, $q->fraction);
        $this->assertEquals($expectedq->feedback, $q->feedback);
        $this->assert(new question_check_specified_fields_expectation($expectedq), $q);
    }

    public function test_export_numerical() {
        $qdata = (object) array(
            'id' => 666 ,
            'name' => 'Q5',
            'questiontext' => "What is a number from 1 to 5?",
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_LION,
            'defaultmark' => 1,
            'penalty' => 1,
            'length' => 1,
            'qtype' => 'numerical',
            'options' => (object) array(
                'id' => 123,
                'question' => 666,
                'showunits' => 0,
                'unitsleft' => 0,
                'showunits' => 2,
                'unitgradingtype' => 0,
                'unitpenalty' => 0,
                'answers' => array(
                    1 => (object) array(
                        'id' => 123,
                        'answer' => '3',
                        'answerformat' => 0,
                        'fraction' => 1,
                        'tolerance' => 2,
                        'feedback' => '',
                        'feedbackformat' => FORMAT_LION,
                    ),
                    2 => (object) array(
                        'id' => 124,
                        'answer' => '*',
                        'answerformat' => 0,
                        'fraction' => 0,
                        'tolerance' => 0,
                        'feedback' => "Completely wrong",
                        'feedbackformat' => FORMAT_LION,
                    ),
                ),
            ),
        );

        $exporter = new qformat_gift();
        $gift = $exporter->writequestion($qdata);

        $expectedgift = "// question: 666  name: Q5
::Q5::What is a number from 1 to 5?{#
\t=%100%3:2#
\t~#Completely wrong
}

";

        $this->assert_same_gift($expectedgift, $gift);
    }

    public function test_import_shortanswer() {
        $gift = "
// question: 666  name: Shortanswer
::Shortanswer::Which is the best animal?{
    =Frog#Good!
    =%50%Cat#What is it with Lionrs and cats?
    =%0%*#Completely wrong
}";
        $lines = preg_split('/[\\n\\r]/', str_replace("\r\n", "\n", $gift));

        $importer = new qformat_gift();
        $q = $importer->readquestion($lines);

        $expectedq = (object) array(
            'name' => 'Shortanswer',
            'questiontext' => "Which is the best animal?",
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_LION,
            'qtype' => 'shortanswer',
            'defaultmark' => 1,
            'penalty' => 0.3333333,
            'length' => 1,
            'answer' => array(
                'Frog',
                'Cat',
                '*',
            ),
            'fraction' => array(1, 0.5, 0),
            'feedback' => array(
                0 => array(
                    'text' => 'Good!',
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
                1 => array(
                    'text' => "What is it with Lionrs and cats?",
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
                2 => array(
                    'text' => "Completely wrong",
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
            ),
        );

        // Repeated test for better failure messages.
        $this->assertEquals($expectedq->answer, $q->answer);
        $this->assertEquals($expectedq->fraction, $q->fraction);
        $this->assertEquals($expectedq->feedback, $q->feedback);
        $this->assert(new question_check_specified_fields_expectation($expectedq), $q);
    }

    public function test_import_shortanswer_with_general_feedback() {
        $gift = "
// question: 666  name: Shortanswer
::Shortanswer::Which is the best animal?{
    =Frog#Good!
    =%50%Cat#What is it with Lionrs and cats?
    =%0%*#Completely wrong
    ####[html]Here is some general feedback!
}";
        $lines = preg_split('/[\\n\\r]/', str_replace("\r\n", "\n", $gift));

        $importer = new qformat_gift();
        $q = $importer->readquestion($lines);

        $expectedq = (object) array(
            'name' => 'Shortanswer',
            'questiontext' => "Which is the best animal?",
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => 'Here is some general feedback!',
            'generalfeedbackformat' => FORMAT_HTML,
            'qtype' => 'shortanswer',
            'defaultmark' => 1,
            'penalty' => 0.3333333,
            'length' => 1,
            'answer' => array(
                'Frog',
                'Cat',
                '*',
            ),
            'fraction' => array(1, 0.5, 0),
            'feedback' => array(
                0 => array(
                    'text' => 'Good!',
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
                1 => array(
                    'text' => "What is it with Lionrs and cats?",
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
                2 => array(
                    'text' => "Completely wrong",
                    'format' => FORMAT_LION,
                    'files' => array(),
                ),
            ),
        );

        // Repeated test for better failure messages.
        $this->assertEquals($expectedq->answer, $q->answer);
        $this->assertEquals($expectedq->fraction, $q->fraction);
        $this->assertEquals($expectedq->feedback, $q->feedback);
        $this->assert(new question_check_specified_fields_expectation($expectedq), $q);
    }

    public function test_export_shortanswer() {
        $qdata = (object) array(
            'id' => 666 ,
            'name' => 'Shortanswer',
            'questiontext' => "Which is the best animal?",
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_LION,
            'defaultmark' => 1,
            'penalty' => 1,
            'length' => 1,
            'qtype' => 'shortanswer',
            'options' => (object) array(
                'id' => 123,
                'questionid' => 666,
                'usecase' => 1,
                'answers' => array(
                    1 => (object) array(
                        'id' => 1,
                        'answer' => 'Frog',
                        'answerformat' => 0,
                        'fraction' => 1,
                        'feedback' => 'Good!',
                        'feedbackformat' => FORMAT_LION,
                    ),
                    2 => (object) array(
                        'id' => 2,
                        'answer' => 'Cat',
                        'answerformat' => 0,
                        'fraction' => 0.5,
                        'feedback' => "What is it with Lionrs and cats?",
                        'feedbackformat' => FORMAT_LION,
                    ),
                    3 => (object) array(
                        'id' => 3,
                        'answer' => '*',
                        'answerformat' => 0,
                        'fraction' => 0,
                        'feedback' => "Completely wrong",
                        'feedbackformat' => FORMAT_LION,
                    ),
                ),
            ),
        );

        $exporter = new qformat_gift();
        $gift = $exporter->writequestion($qdata);

        $expectedgift = "// question: 666  name: Shortanswer
::Shortanswer::Which is the best animal?{
\t=%100%Frog#Good!
\t=%50%Cat#What is it with Lionrs and cats?
\t=%0%*#Completely wrong
}

";

        $this->assert_same_gift($expectedgift, $gift);
    }

    public function test_export_shortanswer_with_general_feedback() {
        $qdata = (object) array(
            'id' => 666 ,
            'name' => 'Shortanswer',
            'questiontext' => "Which is the best animal?",
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => 'Here is some general feedback!',
            'generalfeedbackformat' => FORMAT_HTML,
            'defaultmark' => 1,
            'penalty' => 1,
            'length' => 1,
            'qtype' => 'shortanswer',
            'options' => (object) array(
                'id' => 123,
                'questionid' => 666,
                'usecase' => 1,
                'answers' => array(
                    1 => (object) array(
                        'id' => 1,
                        'answer' => 'Frog',
                        'answerformat' => 0,
                        'fraction' => 1,
                        'feedback' => 'Good!',
                        'feedbackformat' => FORMAT_LION,
                    ),
                    2 => (object) array(
                        'id' => 2,
                        'answer' => 'Cat',
                        'answerformat' => 0,
                        'fraction' => 0.5,
                        'feedback' => "What is it with Lionrs and cats?",
                        'feedbackformat' => FORMAT_LION,
                    ),
                    3 => (object) array(
                        'id' => 3,
                        'answer' => '*',
                        'answerformat' => 0,
                        'fraction' => 0,
                        'feedback' => "Completely wrong",
                        'feedbackformat' => FORMAT_LION,
                    ),
                ),
            ),
        );

        $exporter = new qformat_gift();
        $gift = $exporter->writequestion($qdata);

        $expectedgift = "// question: 666  name: Shortanswer
::Shortanswer::Which is the best animal?{
\t=%100%Frog#Good!
\t=%50%Cat#What is it with Lionrs and cats?
\t=%0%*#Completely wrong
\t####[html]Here is some general feedback!
}

";

        $this->assert_same_gift($expectedgift, $gift);
    }

    public function test_import_truefalse() {
        $gift = "
// true/false
::Q1:: 42 is the Absolute Answer to everything.{
FALSE#42 is the Ultimate Answer.#You gave the right answer.}";
        $lines = preg_split('/[\\n\\r]/', str_replace("\r\n", "\n", $gift));

        $importer = new qformat_gift();
        $q = $importer->readquestion($lines);

        $expectedq = (object) array(
            'name' => 'Q1',
            'questiontext' => "42 is the Absolute Answer to everything.",
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_LION,
            'qtype' => 'truefalse',
            'defaultmark' => 1,
            'penalty' => 1,
            'length' => 1,
            'correctanswer' => 0,
            'feedbacktrue' => array(
                'text' => '42 is the Ultimate Answer.',
                'format' => FORMAT_LION,
                'files' => array(),
            ),
            'feedbackfalse' => array(
                'text' => 'You gave the right answer.',
                'format' => FORMAT_LION,
                'files' => array(),
            ),
        );

        $this->assert(new question_check_specified_fields_expectation($expectedq), $q);
    }

    public function test_import_truefalse_true_answer1() {
        $gift = "// name 0-11
::2-08 TSL::TSL is blablabla.{T}";
        $lines = preg_split('/[\\n\\r]/', str_replace("\r\n", "\n", $gift));

        $importer = new qformat_gift();
        $q = $importer->readquestion($lines);

        $expectedq = (object) array(
            'name' => '2-08 TSL',
            'questiontext' => "TSL is blablabla.",
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_LION,
            'qtype' => 'truefalse',
            'defaultmark' => 1,
            'penalty' => 1,
            'length' => 1,
            'correctanswer' => 1,
            'feedbacktrue' => array(
                'text' => '',
                'format' => FORMAT_LION,
                'files' => array(),
            ),
            'feedbackfalse' => array(
                'text' => '',
                'format' => FORMAT_LION,
                'files' => array(),
            ),
        );

        $this->assert(new question_check_specified_fields_expectation($expectedq), $q);
    }

    public function test_import_truefalse_true_answer2() {
        $gift = "// name 0-11
::2-08 TSL::TSL is blablabla.{TRUE}";
        $lines = preg_split('/[\\n\\r]/', str_replace("\r\n", "\n", $gift));

        $importer = new qformat_gift();
        $q = $importer->readquestion($lines);

        $expectedq = (object) array(
            'name' => '2-08 TSL',
            'questiontext' => "TSL is blablabla.",
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_LION,
            'qtype' => 'truefalse',
            'defaultmark' => 1,
            'penalty' => 1,
            'length' => 1,
            'correctanswer' => 1,
            'feedbacktrue' => array(
                'text' => '',
                'format' => FORMAT_LION,
                'files' => array(),
            ),
            'feedbackfalse' => array(
                'text' => '',
                'format' => FORMAT_LION,
                'files' => array(),
            ),
        );

        $this->assert(new question_check_specified_fields_expectation($expectedq), $q);
    }

    public function test_export_truefalse() {
        $qdata = (object) array(
            'id' => 666 ,
            'name' => 'Q1',
            'questiontext' => "42 is the Absolute Answer to everything.",
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_LION,
            'defaultmark' => 1,
            'penalty' => 1,
            'length' => 1,
            'qtype' => 'truefalse',
            'options' => (object) array(
                'id' => 123,
                'question' => 666,
                'trueanswer' => 1,
                'falseanswer' => 2,
                'answers' => array(
                    1 => (object) array(
                        'id' => 123,
                        'answer' => 'True',
                        'answerformat' => 0,
                        'fraction' => 1,
                        'feedback' => 'You gave the right answer.',
                        'feedbackformat' => FORMAT_LION,
                    ),
                    2 => (object) array(
                        'id' => 124,
                        'answer' => 'False',
                        'answerformat' => 0,
                        'fraction' => 0,
                        'feedback' => "42 is the Ultimate Answer.",
                        'feedbackformat' => FORMAT_HTML,
                    ),
                ),
            ),
        );

        $exporter = new qformat_gift();
        $gift = $exporter->writequestion($qdata);

        $expectedgift = "// question: 666  name: Q1
::Q1::42 is the Absolute Answer to everything.{TRUE#[html]42 is the Ultimate Answer.#You gave the right answer.}

";

        $this->assert_same_gift($expectedgift, $gift);
    }

    public function test_export_backslash() {
        // There was a bug (MDL-34171) where \\ was getting exported as \\, not
        // \\\\, and on import, \\ in converted to \.
        // We need \\\\ in the test code, because of PHPs string escaping rules.
        $qdata = (object) array(
            'id' => 666 ,
            'name' => 'backslash',
            'questiontext' => 'A \\ B \\\\ C',
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_LION,
            'defaultmark' => 1,
            'penalty' => 0.3333333,
            'length' => 1,
            'qtype' => 'essay',
            'options' => (object) array(
                'responseformat' => 'editor',
                'responsefieldlines' => 15,
                'attachments' => 0,
                'graderinfo' => '',
                'graderinfoformat' => FORMAT_HTML,
            ),
        );

        $exporter = new qformat_gift();
        $gift = $exporter->writequestion($qdata);

        $expectedgift = "// question: 666  name: backslash
::backslash::A \\\\ B \\\\\\\\ C{}

";

        $this->assert_same_gift($expectedgift, $gift);
    }

    public function test_import_backslash() {
        // There was a bug (MDL-34171) where \\ in the import was getting changed
        // to \. This test checks for that.
        // We need \\\\ in the test code, because of PHPs string escaping rules.
        $gift = '
// essay
::double backslash:: A \\\\ B \\\\\\\\ C{}';
        $lines = preg_split('/[\\n\\r]/', str_replace("\r\n", "\n", $gift));

        $importer = new qformat_gift();
        $q = $importer->readquestion($lines);

        $expectedq = (object) array(
            'name' => 'double backslash',
            'questiontext' => 'A \\ B \\\\ C',
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_LION,
            'qtype' => 'essay',
            'defaultmark' => 1,
            'penalty' => 0.3333333,
            'length' => 1,
            'responseformat' => 'editor',
            'responsefieldlines' => 15,
            'attachments' => 0,
            'graderinfo' => array(
                'text' => '',
                'format' => FORMAT_HTML,
                'files' => array()),
        );

        $this->assert(new question_check_specified_fields_expectation($expectedq), $q);
    }

    public function test_import_pre_content() {
        $gift = '
::Q001::[html]<p>What would running the test method print?</p>
<pre>
    public void test() \{
        method1();
        method2();
        method3();
    \}
</pre>
{}';
        $lines = preg_split('/[\\n\\r]/', str_replace("\r\n", "\n", $gift));

        $importer = new qformat_gift();
        $q = $importer->readquestion($lines);

        $expectedq = (object) array(
            'name' => 'Q001',
            'questiontext' => '<p>What would running the test method print?</p>
<pre>
    public void test() {
        method1();
        method2();
        method3();
    }
</pre>',
            'questiontextformat' => FORMAT_HTML,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_HTML,
            'qtype' => 'essay',
            'defaultmark' => 1,
            'penalty' => 0.3333333,
            'length' => 1,
            'responseformat' => 'editor',
            'responsefieldlines' => 15,
            'attachments' => 0,
            'graderinfo' => array(
                'text' => '',
                'format' => FORMAT_HTML,
                'files' => array()),
        );

        $this->assert(new question_check_specified_fields_expectation($expectedq), $q);
    }
}
