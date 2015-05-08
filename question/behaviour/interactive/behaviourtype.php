<?php

/**
 * Question behaviour type for interactive behaviour.
 *
 * @package    qbehaviour_interactive
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Question behaviour type information for interactive behaviour.
 *
 * @copyright  2015 Pooya Saeedi
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
