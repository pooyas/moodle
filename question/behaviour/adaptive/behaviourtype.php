<?php


/**
 * Question behaviour type for adaptive behaviour.
 *
 * @package    question_behaviour
 * @subpackage adaptive
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();


/**
 * Question behaviour type information for adaptive behaviour.
 *
 */
class qbehaviour_adaptive_type extends question_behaviour_type {
    public function is_archetypal() {
        return true;
    }

    public function allows_multiple_submitted_responses() {
        return true;
    }
}
