<?php

/**
 * Fake question behaviour that is used when the actual behaviour was not
 * available.
 *
 * @package    qbehaviour
 * @subpackage missing
 * @copyright  2009 The Open University
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Fake question behaviour that is used when the actual behaviour
 * is not available.
 *
 * Imagine, for example, that a quiz attempt has been restored from another
 * Lion site with more behaviours installed, or a behaviour
 * that used to be available in this site has been uninstalled. Obviously all we
 * can do is have some code to prevent fatal errors.
 *
 * The approach we take is: The rendering code is still implemented, as far as
 * possible. A warning is shown that behaviour specific bits may be missing.
 * Any attempt to process anything causes an exception to be thrown.
 *
 * @copyright  2009 The Open University
 * 
 */
class qbehaviour_missing extends question_behaviour {

    public function is_compatible_question(question_definition $question) {
        return true;
    }

    public function summarise_action(question_attempt_step $step) {
        return '';
    }

    public function init_first_step(question_attempt_step $step, $variant) {
        throw new coding_exception('The behaviour used for this question is not available. ' .
                'No processing is possible.');
    }

    public function process_action(question_attempt_pending_step $pendingstep) {
        throw new coding_exception('The behaviour used for this question is not available. ' .
                'No processing is possible.');
    }

    public function get_min_fraction() {
        throw new coding_exception('The behaviour used for this question is not available. ' .
                'No processing is possible.');
    }

    public function get_max_fraction() {
        throw new coding_exception('The behaviour used for this question is not available. ' .
                'No processing is possible.');
    }
}
