<?php

/**
 * Question behaviour type for adaptive behaviour.
 *
 * @package    qbehaviour_adaptive
 * @copyright  2012 The Open University
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Question behaviour type information for adaptive behaviour.
 *
 * @copyright  2012 The Open University
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
