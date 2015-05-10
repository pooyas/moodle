<?php

/**
 * Unit tests for the description question type class.
 *
 * @package    qtype
 * @subpackage description
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/type/description/questiontype.php');
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');
require_once($CFG->dirroot . '/question/type/edit_question_form.php');
require_once($CFG->dirroot . '/question/type/description/edit_description_form.php');


/**
 * Unit tests for the description question type class.
 *
 */
class qtype_description_test extends advanced_testcase {
    protected $qtype;

    protected function setUp() {
        $this->qtype = new qtype_description();
    }

    protected function tearDown() {
        $this->qtype = null;
    }

    public function test_name() {
        $this->assertEquals($this->qtype->name(), 'description');
    }

    public function test_actual_number_of_questions() {
        $this->assertEquals(0, $this->qtype->actual_number_of_questions(null));
    }

    public function test_can_analyse_responses() {
        $this->assertFalse($this->qtype->can_analyse_responses());
    }

    public function test_get_random_guess_score() {
        $this->assertNull($this->qtype->get_random_guess_score(null));
    }

    public function test_get_possible_responses() {
        $this->assertEquals(array(), $this->qtype->get_possible_responses(null));
    }


    public function test_question_saving() {
        $this->resetAfterTest(true);
        $this->setAdminUser();

        $questiondata = test_question_maker::get_question_data('description');
        $formdata = test_question_maker::get_question_form_data('description');

        $generator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $cat = $generator->create_question_category(array());

        $formdata->category = "{$cat->id},{$cat->contextid}";
        qtype_description_edit_form::mock_submit((array)$formdata);

        $form = qtype_description_test_helper::get_question_editing_form($cat, $questiondata);

        $this->assertTrue($form->is_validated());

        $fromform = $form->get_data();

        $returnedfromsave = $this->qtype->save_question($questiondata, $fromform);
        $actualquestionsdata = question_load_questions(array($returnedfromsave->id));
        $actualquestiondata = end($actualquestionsdata);

        foreach ($questiondata as $property => $value) {
            if (!in_array($property, array('id', 'version', 'timemodified', 'timecreated'))) {
                $this->assertAttributeEquals($value, $property, $actualquestiondata);
            }
        }
    }
}
