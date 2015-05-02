<?php

/**
 * Question behaviour type for immediate feedback behaviour.
 *
 * @package    qbehaviour_immediatefeedback
 * @copyright  2012 The Open University
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Question behaviour type information for immediate feedback behaviour.
 *
 * @copyright  2012 The Open University
 * 
 */
class qbehaviour_immediatefeedback_type extends question_behaviour_type {
    public function is_archetypal() {
        return true;
    }
}
