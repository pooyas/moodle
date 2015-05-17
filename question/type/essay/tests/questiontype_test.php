<?php


/**
 * Unit tests for the essay question type class.
 *
 * @package    question_type
 * @subpackage essay
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/type/essay/questiontype.php');


/**
 * Unit tests for the essay question type class.
 *
 */
class qtype_essay_test extends advanced_testcase {
    protected $qtype;

    protected function setUp() {
        $this->qtype = new qtype_essay();
    }

    protected function tearDown() {
        $this->qtype = null;
    }

    protected function get_test_question_data() {
        $q = new stdClass();
        $q->id = 1;

        return $q;
    }

    public function test_name() {
        $this->assertEquals($this->qtype->name(), 'essay');
    }

    public function test_can_analyse_responses() {
        $this->assertFalse($this->qtype->can_analyse_responses());
    }

    public function test_get_random_guess_score() {
        $q = $this->get_test_question_data();
        $this->assertEquals(0, $this->qtype->get_random_guess_score($q));
    }

    public function test_get_possible_responses() {
        $q = $this->get_test_question_data();
        $this->assertEquals(array(), $this->qtype->get_possible_responses($q));

    }
}
