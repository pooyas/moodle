<?php

/**
 * Question behaviour type for immediate feedback behaviour.
 *
 * @package    qbehaviour_immediatefeedback
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Question behaviour type information for immediate feedback behaviour.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class qbehaviour_immediatefeedback_type extends question_behaviour_type {
    public function is_archetypal() {
        return true;
    }
}
