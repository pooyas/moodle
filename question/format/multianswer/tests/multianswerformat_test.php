<?php

/**
 * Unit tests for the Embedded answer (Cloze) question importer.
 *
 * @package   qformat
 * @subpackage multianswer
 * @category   phpunit
 * @copyright 2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/questionlib.php');
require_once($CFG->dirroot . '/question/format.php');
require_once($CFG->dirroot . '/question/format/multianswer/format.php');
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');


/**
 * Unit tests for the Embedded answer (Cloze) question importer.
 *
 */
class qformat_multianswer_test extends question_testcase {

    public function test_import() {
        $lines = file(__DIR__ . '/fixtures/questions.multianswer.txt');

        $importer = new qformat_multianswer();
        $qs = $importer->readquestions($lines);

        $expectedq = (object) array(
            'name' => 'Match the following cities with the correct state:
* San Francisco: {#1}
* ...',
            'questiontext' => 'Match the following cities with the correct state:
* San Francisco: {#1}
* Tucson: {#2}
* Los Angeles: {#3}
* Phoenix: {#4}
The capital of France is {#5}.
',
            'questiontextformat' => FORMAT_LION,
            'generalfeedback' => '',
            'generalfeedbackformat' => FORMAT_LION,
            'qtype' => 'multianswer',
            'defaultmark' => 5,
            'penalty' => 0.3333333,
            'length' => 1,
        );

        $this->assertEquals(1, count($qs));
        $this->assert(new question_check_specified_fields_expectation($expectedq), $qs[0]);

        $this->assertEquals('multichoice', $qs[0]->options->questions[1]->qtype);
        $this->assertEquals('multichoice', $qs[0]->options->questions[2]->qtype);
        $this->assertEquals('multichoice', $qs[0]->options->questions[3]->qtype);
        $this->assertEquals('multichoice', $qs[0]->options->questions[4]->qtype);
        $this->assertEquals('shortanswer', $qs[0]->options->questions[5]->qtype);
    }
}
