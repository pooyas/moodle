<?php

/**
 * This file contains tests for the question_attempt_iterator class.
 *
 * @package    lioncore
 * @subpackage questionengine
 * @copyright  2009 The Open University
 * 
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once(dirname(__FILE__) . '/../lib.php');
require_once(dirname(__FILE__) . '/helpers.php');


/**
 * This file contains tests for the {@link question_attempt_iterator} class.
 *
 * @copyright  2009 The Open University
 * 
 */
class question_attempt_iterator_test extends advanced_testcase {
    private $quba;
    private $qas = array();
    private $iterator;

    protected function setUp() {
        $this->quba = question_engine::make_questions_usage_by_activity('unit_test',
                context_system::instance());
        $this->quba->set_preferred_behaviour('deferredfeedback');

        $slot = $this->quba->add_question(test_question_maker::make_question('description'));
        $this->qas[$slot] = $this->quba->get_question_attempt($slot);

        $slot = $this->quba->add_question(test_question_maker::make_question('description'));
        $this->qas[$slot] = $this->quba->get_question_attempt($slot);

        $this->iterator = $this->quba->get_attempt_iterator();
    }

    protected function tearDown() {
        $this->quba = null;
        $this->iterator = null;
    }

    public function test_foreach_loop() {
        $i = 1;
        foreach ($this->iterator as $key => $qa) {
            $this->assertEquals($i, $key);
            $this->assertSame($this->qas[$i], $qa);
            $i++;
        }
        $this->assertEquals(3, $i);
    }

    public function test_offsetExists_before_start() {
        $this->assertFalse(isset($this->iterator[0]));
    }

    public function test_offsetExists_at_start() {
        $this->assertTrue(isset($this->iterator[1]));
    }

    public function test_offsetExists_at_endt() {
        $this->assertTrue(isset($this->iterator[2]));
    }

    public function test_offsetExists_past_end() {
        $this->assertFalse(isset($this->iterator[3]));
    }

    public function test_offsetGet_before_start() {
        $this->setExpectedException('lion_exception');
        $step = $this->iterator[0];
    }

    public function test_offsetGet_at_start() {
        $this->assertSame($this->qas[1], $this->iterator[1]);
    }

    public function test_offsetGet_at_end() {
        $this->assertSame($this->qas[2], $this->iterator[2]);
    }

    public function test_offsetGet_past_end() {
        $this->setExpectedException('lion_exception');
        $step = $this->iterator[3];
    }

    public function test_cannot_set() {
        $this->setExpectedException('lion_exception');
        $this->iterator[0] = null;
    }

    public function test_cannot_unset() {
        $this->setExpectedException('lion_exception');
        unset($this->iterator[2]);
    }
}