<?php

/**
 * Question behaviour type for interactive behaviour.
 *
 * @package    qbehaviour_interactive
 * @copyright  2012 The Open University
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Question behaviour type information for interactive behaviour.
 *
 * @copyright  2012 The Open University
 * 
 */
class qbehaviour_interactive_type extends question_behaviour_type {
    public function is_archetypal() {
        return true;
    }

    public function allows_multiple_submitted_responses() {
        return true;
    }
}
