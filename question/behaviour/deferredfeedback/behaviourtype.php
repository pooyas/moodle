<?php

/**
 * Question behaviour type for deferred feedback behaviour.
 *
 * @package    qbehaviour_deferredfeedback
 * @copyright  2012 The Open University
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Question behaviour type information for deferred feedback behaviour.
 *
 * @copyright  2012 The Open University
 * 
 */
class qbehaviour_deferredfeedback_type extends question_behaviour_type {
    public function is_archetypal() {
        return true;
    }

    public function get_unused_display_options() {
        return array('correctness', 'marks', 'specificfeedback', 'generalfeedback',
                'rightanswer');
    }
}
