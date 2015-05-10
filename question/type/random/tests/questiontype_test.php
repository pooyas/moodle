<?php

/**
 * Unit tests for the random question type class.
 *
 * @package    qtype
 * @subpackage random
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/type/random/questiontype.php');


/**
 * Unit tests for the random question type class.
 *
 */
class qtype_random_test extends advanced_testcase {
    protected $qtype;

    protected function setUp() {
        $this->qtype = new qtype_random();
    }

    protected function tearDown() {
        $this->qtype = null;
    }

    public function test_name() {
        $this->assertEquals($this->qtype->name(), 'random');
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

    public function test_question_creation() {
        $this->resetAfterTest();
        question_bank::get_qtype('random')->clear_caches_before_testing();

        $generator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $cat = $generator->create_question_category();
        $question1 = $generator->create_question('shortanswer', null, array('category' => $cat->id));
        $question2 = $generator->create_question('numerical', null, array('category' => $cat->id));

        $randomquestion = $generator->create_question('random', null, array('category' => $cat->id));

        $expectedids = array($question1->id, $question2->id);
        $actualids = question_bank::get_qtype('random')->get_available_questions_from_category($cat->id, 0);
        sort($expectedids);
        sort($actualids);
        $this->assertEquals($expectedids, $actualids);

        $q = question_bank::load_question($randomquestion->id);

        $this->assertContains($q->id, array($question1->id, $question2->id));
    }
}
