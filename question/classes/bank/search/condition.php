<?php


/**
 * Defines an abstract class for filtering/searching the question bank.
 *
 * @package   core
 * @subpackage question
 * @copyright 2015 Pooya Saeedi
 * 
 */

namespace core_question\bank\search;
defined('LION_INTERNAL') || die();

/**
 * An abstract class for filtering/searching questions.
 *
 * See also {@link question_bank_view::init_search_conditions()}.
 * 
 */
abstract class condition {
    /**
     * Return an SQL fragment to be ANDed into the WHERE clause to filter which questions are shown.
     * @return string SQL fragment. Must use named parameters.
     */
    public abstract function where();

    /**
     * Return parameters to be bound to the above WHERE clause fragment.
     * @return array parameter name => value.
     */
    public function params() {
        return array();
    }

    /**
     * Display GUI for selecting criteria for this condition. Displayed when Show More is open.
     *
     * Compare display_options(), which displays always, whether Show More is open or not.
     * @return string HTML form fragment
     */
    public function display_options_adv() {
        return;
    }

    /**
     * Display GUI for selecting criteria for this condition. Displayed always, whether Show More is open or not.
     *
     * Compare display_options_adv(), which displays when Show More is open.
     * @return string HTML form fragment
     */
    public function display_options() {
        return;
    }
}
