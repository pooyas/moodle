<?php

/**
 * This file contains tests for the question_engine class.
 *
 * @package    core
 * @subpackage questionengine
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once(dirname(__FILE__) . '/../lib.php');


/**
 *Unit tests for the question_engine class.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class question_engine_test extends advanced_testcase {

    public function test_load_behaviour_class() {
        // Exercise SUT
        question_engine::load_behaviour_class('deferredfeedback');
        // Verify
        $this->assertTrue(class_exists('qbehaviour_deferredfeedback'));
    }

    public function test_load_behaviour_class_missing() {
        // Set expectation.
        $this->setExpectedException('lion_exception');
        // Exercise SUT
        question_engine::load_behaviour_class('nonexistantbehaviour');
    }

    public function test_get_behaviour_unused_display_options() {
        $this->assertEquals(array(), question_engine::get_behaviour_unused_display_options('interactive'));
        $this->assertEquals(array('correctness', 'marks', 'specificfeedback', 'generalfeedback', 'rightanswer'),
                question_engine::get_behaviour_unused_display_options('deferredfeedback'));
        $this->assertEquals(array('correctness', 'marks', 'specificfeedback', 'generalfeedback', 'rightanswer'),
                question_engine::get_behaviour_unused_display_options('deferredcbm'));
        $this->assertEquals(array('correctness', 'marks', 'specificfeedback', 'generalfeedback', 'rightanswer'),
                question_engine::get_behaviour_unused_display_options('manualgraded'));
    }

    public function test_sort_behaviours() {
        $in = array('b1' => 'Behave 1', 'b2' => 'Behave 2', 'b3' => 'Behave 3', 'b4' => 'Behave 4', 'b5' => 'Behave 5', 'b6' => 'Behave 6');

        $out = array('b1' => 'Behave 1', 'b2' => 'Behave 2', 'b3' => 'Behave 3', 'b4' => 'Behave 4', 'b5' => 'Behave 5', 'b6' => 'Behave 6');
        $this->assertSame($out, question_engine::sort_behaviours($in, '', '', ''));

        $this->assertSame($out, question_engine::sort_behaviours($in, '', 'b4', 'b4'));

        $out = array('b4' => 'Behave 4', 'b5' => 'Behave 5', 'b6' => 'Behave 6');
        $this->assertSame($out, question_engine::sort_behaviours($in, '', 'b1,b2,b3,b4', 'b4'));

        $out = array('b6' => 'Behave 6', 'b1' => 'Behave 1', 'b4' => 'Behave 4');
        $this->assertSame($out, question_engine::sort_behaviours($in, 'b6,b1,b4', 'b2,b3,b4,b5', 'b4'));

        $out = array('b6' => 'Behave 6', 'b5' => 'Behave 5', 'b4' => 'Behave 4');
        $this->assertSame($out, question_engine::sort_behaviours($in, 'b6,b5,b4', 'b1,b2,b3', 'b4'));

        $out = array('b6' => 'Behave 6', 'b5' => 'Behave 5', 'b4' => 'Behave 4');
        $this->assertSame($out, question_engine::sort_behaviours($in, 'b1,b6,b5', 'b1,b2,b3,b4', 'b4'));

        $out = array('b2' => 'Behave 2', 'b4' => 'Behave 4', 'b6' => 'Behave 6');
        $this->assertSame($out, question_engine::sort_behaviours($in, 'b2,b4,b6', 'b1,b3,b5', 'b2'));

        // Ignore unknown input in the order argument.
        $this->assertSame($in, question_engine::sort_behaviours($in, 'unknown', '', ''));

        // Ignore unknown input in the disabled argument.
        $this->assertSame($in, question_engine::sort_behaviours($in, '', 'unknown', ''));
    }
}