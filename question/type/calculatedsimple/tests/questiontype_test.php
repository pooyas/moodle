<?php


/**
 * Unit tests for the calculatedsimple question type class.
 *
 * @package    question_type
 * @subpackage calculatedsimple
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/type/calculatedsimple/questiontype.php');
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');
require_once($CFG->dirroot . '/question/type/edit_question_form.php');
require_once($CFG->dirroot . '/question/type/calculatedsimple/edit_calculatedsimple_form.php');


/**
 * Unit tests for the calculatedsimple question type class.
 *
 */
class qtype_calculatedsimple_test extends advanced_testcase {
    public static $includecoverage = array(
        'question/type/questiontypebase.php',
        'question/type/calculatedsimple/questiontype.php',
        'question/type/edit_question_form.php',
        'question/type/calculatedsimple/edit_calculatedsimple_form.php'
    );

    protected $qtype;

    protected function setUp() {
        $this->qtype = new qtype_calculatedsimple();
    }

    protected function tearDown() {
        $this->qtype = null;
    }

    public function test_name() {
        $this->assertEquals($this->qtype->name(), 'calculatedsimple');
    }

    public function test_can_analyse_responses() {
        $this->assertTrue($this->qtype->can_analyse_responses());
    }


    public function test_question_saving_sumwithvariants() {
        $this->resetAfterTest(true);
        $this->setAdminUser();

        $questiondata = test_question_maker::get_question_data('calculatedsimple', 'sumwithvariants');
        $formdata = test_question_maker::get_question_form_data('calculatedsimple', 'sumwithvariants');

        $generator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $cat = $generator->create_question_category(array());

        $formdata->category = "{$cat->id},{$cat->contextid}";
        qtype_calculatedsimple_edit_form::mock_submit((array)$formdata);

        $form = qtype_calculatedsimple_test_helper::get_question_editing_form($cat, $questiondata);

        $this->assertTrue($form->is_validated());

        $fromform = $form->get_data();

        $returnedfromsave = $this->qtype->save_question($questiondata, $fromform);
        $actualquestionsdata = question_load_questions(array($returnedfromsave->id));
        $actualquestiondata = end($actualquestionsdata);

        foreach ($questiondata as $property => $value) {
            if (!in_array($property, array('id', 'version', 'timemodified', 'timecreated', 'options'))) {
                $this->assertAttributeEquals($value, $property, $actualquestiondata);
            }
        }

        foreach ($questiondata->options as $optionname => $value) {
            if ($optionname != 'answers') {
                $this->assertAttributeEquals($value, $optionname, $actualquestiondata->options);
            }
        }

        foreach ($questiondata->options->answers as $answer) {
            $actualanswer = array_shift($actualquestiondata->options->answers);
            foreach ($answer as $ansproperty => $ansvalue) {
                if (!in_array($ansproperty, array('id', 'question', 'answerformat'))) {
                    $this->assertAttributeEquals($ansvalue, $ansproperty, $actualanswer);
                }
            }
        }

        $datasetloader = new qtype_calculated_dataset_loader($actualquestiondata->id);

        $this->assertEquals(10, $datasetloader->get_number_of_items());

        for ($itemno = 1; $itemno <= 10; $itemno++) {
            $item = $datasetloader->get_values($itemno);
            $this->assertEquals($formdata->number[($itemno -1)*2 + 2], $item['a']);
            $this->assertEquals($formdata->number[($itemno -1)*2 + 1], $item['b']);
        }
    }
}
