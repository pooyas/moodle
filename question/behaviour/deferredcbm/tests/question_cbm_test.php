<?php

/**
 * This file contains tests that walks a question through the deferred feedback
 * with certainty base marking behaviour.
 *
 * @package    qbehaviour
 * @subpackage deferredcbm
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once(dirname(__FILE__) . '/../../../engine/lib.php');


/**
 * Unit tests for the deferred feedback with certainty base marking behaviour.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class qbehaviour_deferredcbm_cbm_test extends basic_testcase {

    public function test_adjust_fraction() {
        $this->assertEquals( 1,   question_cbm::adjust_fraction( 1,    question_cbm::LOW),  '', 0.0000001);
        $this->assertEquals( 2,   question_cbm::adjust_fraction( 1,    question_cbm::MED),  '', 0.0000001);
        $this->assertEquals( 3,   question_cbm::adjust_fraction( 1,    question_cbm::HIGH), '', 0.0000001);
        $this->assertEquals( 0,   question_cbm::adjust_fraction( 0,    question_cbm::LOW),  '', 0.0000001);
        $this->assertEquals(-2,   question_cbm::adjust_fraction( 0,    question_cbm::MED),  '', 0.0000001);
        $this->assertEquals(-6,   question_cbm::adjust_fraction( 0,    question_cbm::HIGH), '', 0.0000001);
        $this->assertEquals( 0.5, question_cbm::adjust_fraction( 0.5,  question_cbm::LOW),  '', 0.0000001);
        $this->assertEquals( 1,   question_cbm::adjust_fraction( 0.5,  question_cbm::MED),  '', 0.0000001);
        $this->assertEquals( 1.5, question_cbm::adjust_fraction( 0.5,  question_cbm::HIGH), '', 0.0000001);
        $this->assertEquals( 0,   question_cbm::adjust_fraction(-0.25, question_cbm::LOW),  '', 0.0000001);
        $this->assertEquals(-2,   question_cbm::adjust_fraction(-0.25, question_cbm::MED),  '', 0.0000001);
        $this->assertEquals(-6,   question_cbm::adjust_fraction(-0.25, question_cbm::HIGH), '', 0.0000001);
    }
}
