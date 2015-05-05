<?php

/**
 * Implementaton of the quizaccess_timelimit plugin.
 *
 * @package    quizaccess
 * @subpackage timelimit
 * @copyright  2011 The Open University
 * 
 */


defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/quiz/accessrule/accessrulebase.php');


/**
 * A rule representing the time limit. It does not actually restrict access, but we use this
 * class to encapsulate some of the relevant code.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class quizaccess_timelimit extends quiz_access_rule_base {

    public static function make(quiz $quizobj, $timenow, $canignoretimelimits) {

        if (empty($quizobj->get_quiz()->timelimit) || $canignoretimelimits) {
            return null;
        }

        return new self($quizobj, $timenow);
    }

    public function description() {
        return get_string('quiztimelimit', 'quizaccess_timelimit',
                format_time($this->quiz->timelimit));
    }

    public function end_time($attempt) {
        return $attempt->timestart + $this->quiz->timelimit;
    }

    public function time_left_display($attempt, $timenow) {
        // If this is a teacher preview after the time limit expires, don't show the time_left
        $endtime = $this->end_time($attempt);
        if ($attempt->preview && $timenow > $endtime) {
            return false;
        }
        return $endtime - $timenow;

    }
}
