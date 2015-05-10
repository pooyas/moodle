<?php

/**
 * Implementaton of the quizaccess_numattempts plugin.
 *
 * @package    quizaccess
 * @subpackage numattempts
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/quiz/accessrule/accessrulebase.php');


/**
 * A rule controlling the number of attempts allowed.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class quizaccess_numattempts extends quiz_access_rule_base {

    public static function make(quiz $quizobj, $timenow, $canignoretimelimits) {

        if ($quizobj->get_num_attempts_allowed() == 0) {
            return null;
        }

        return new self($quizobj, $timenow);
    }

    public function description() {
        return get_string('attemptsallowedn', 'quizaccess_numattempts', $this->quiz->attempts);
    }

    public function prevent_new_attempt($numprevattempts, $lastattempt) {
        if ($numprevattempts >= $this->quiz->attempts) {
            return get_string('nomoreattempts', 'quiz');
        }
        return false;
    }

    public function is_finished($numprevattempts, $lastattempt) {
        return $numprevattempts >= $this->quiz->attempts;
    }
}
