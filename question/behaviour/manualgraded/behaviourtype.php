<?php


/**
 * Question behaviour type for manually graded behaviour.
 *
 * @package    question_behaviour
 * @subpackage manualgraded
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();


/**
 * Question behaviour type information for manually graded behaviour.
 *
 */
class qbehaviour_manualgraded_type extends question_behaviour_type {
    public function is_archetypal() {
        return true;
    }

    public function get_unused_display_options() {
        return array('correctness', 'marks', 'specificfeedback', 'generalfeedback',
                'rightanswer');
    }
}
