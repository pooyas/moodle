<?php

/**
 * This file contains tests for the deferred feedback behaviour type class.
 *
 * @package   qbehaviour
 * @subpackage deferredfeedback
 * @category  phpunit
 * @copyright 2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once(dirname(__FILE__) . '/../../../engine/lib.php');
require_once(dirname(__FILE__) . '/../../../engine/tests/helpers.php');


/**
 * Unit tests for the deferred feedback behaviour type class.
 *
 */
class qbehaviour_deferredfeedback_type_test extends qbehaviour_walkthrough_test_base {

    /** @var qbehaviour_deferredfeedback_type */
    protected $behaviourtype;

    public function setUp() {
        parent::setUp();
        $this->behaviourtype = question_engine::get_behaviour_type('deferredfeedback');
    }

    public function test_is_archetypal() {
        $this->assertTrue($this->behaviourtype->is_archetypal());
    }

    public function test_get_unused_display_options() {
        $this->assertEquals(array('correctness', 'marks', 'specificfeedback', 'generalfeedback', 'rightanswer'),
                $this->behaviourtype->get_unused_display_options());
    }

    public function test_adjust_random_guess_score() {
        $this->assertEquals(0, $this->behaviourtype->adjust_random_guess_score(0));
        $this->assertEquals(1, $this->behaviourtype->adjust_random_guess_score(1));
    }
}
