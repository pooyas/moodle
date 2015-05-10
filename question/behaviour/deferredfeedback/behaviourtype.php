<?php

/**
 * Question behaviour type for deferred feedback behaviour.
 *
 * @package    qbehaviour
 * @subpackage deferredfeedback
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Question behaviour type information for deferred feedback behaviour.
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
