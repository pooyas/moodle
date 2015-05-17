<?php


/**
 * Unit tests for the true-false question definition class.
 *
 * @package    question_type
 * @subpackage truefalse
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/type/truefalse/questiontype.php');
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');
require_once($CFG->dirroot . '/question/type/edit_question_form.php');
require_once($CFG->dirroot . '/question/type/truefalse/edit_truefalse_form.php');

/**
 * Unit tests for the true-false question definition class.
 *
 */
class qtype_truefalse_test extends advanced_testcase {
    protected $qtype;

    protected function setUp() {
        $this->qtype = new qtype_truefalse();
    }

    protected function tearDown() {
        $this->qtype = null;
    }

    public function test_name() {
        $this->assertEquals($this->qtype->name(), 'truefalse');
    }

    public function test_can_analyse_responses() {
        $this->assertTrue($this->qtype->can_analyse_responses());
    }

    public function test_get_random_guess_score() {
        $this->assertEquals(0.5, $this->qtype->get_random_guess_score(null));
    }

    public function test_get_possible_responses() {
        $q = new stdClass();
        $q->id = 1;
        $q->options = new stdClass();
        $q->options->trueanswer = 1;
        $q->options->falseanswer = 2;
        $q->options->answers[1] = (object) array('fraction' => 1);
        $q->options->answers[2] = (object) array('fraction' => 0);

        $this->assertEquals(array(
            $q->id => array(
                0 => new question_possible_response(get_string('false', 'qtype_truefalse'), 0),
                1 => new question_possible_response(get_string('true', 'qtype_truefalse'), 1),
                null => question_possible_response::no_response()),
        ), $this->qtype->get_possible_responses($q));
    }

    public function test_question_saving_true() {
        $this->resetAfterTest(true);
        $this->setAdminUser();

        $questiondata = test_question_maker::get_question_data('truefalse');
        $formdata = test_question_maker::get_question_form_data('truefalse');

        $generator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $cat = $generator->create_question_category(array());

        $formdata->category = "{$cat->id},{$cat->contextid}";
        qtype_truefalse_edit_form::mock_submit((array)$formdata);

        $form = qtype_truefalse_test_helper::get_question_editing_form($cat, $questiondata);

        $this->assertTrue($form->is_validated());

        $fromform = $form->get_data();

        $returnedfromsave = $this->qtype->save_question($questiondata, $fromform);
        $actualquestionsdata = question_load_questions(array($returnedfromsave->id));
        $actualquestiondata = end($actualquestionsdata);

        foreach ($questiondata as $property => $value) {
            if (!in_array($property, array('options'))) {
                $this->assertAttributeEquals($value, $property, $actualquestiondata);
            }
        }

        foreach ($questiondata->options as $optionname => $value) {
            if (!in_array($optionname, array('trueanswer', 'falseanswer', 'answers'))) {
                $this->assertAttributeEquals($value, $optionname, $actualquestiondata->options);
            }
        }

        $answerindexes = array();
        foreach ($questiondata->options->answers as $ansindex => $answer) {
            $actualanswer = array_shift($actualquestiondata->options->answers);
            foreach ($answer as $ansproperty => $ansvalue) {
                // This question does not use 'answerformat', will ignore it.
                if (!in_array($ansproperty, array('id', 'question', 'answerformat'))) {
                    $this->assertAttributeEquals($ansvalue, $ansproperty, $actualanswer);
                }
            }
            $answerindexes[$answer->answer] = $ansindex;
        }

        $this->assertEquals($questiondata->options->trueanswer, $answerindexes['True']);
        $this->assertEquals($questiondata->options->falseanswer, $answerindexes['False']);
    }
}
