<?php


/**
 * Question behaviour type for interactive behaviour.
 *
 * @package    question_behaviour
 * @subpackage interactive
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();


/**
 * Question behaviour type information for interactive behaviour.
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
