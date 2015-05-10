<?php

/**
 * Library code used by quiz cron.
 *
 * @package   mod
 * @subpackage quiz
 * @copyright 2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/quiz/locallib.php');


/**
 * This class holds all the code for automatically updating all attempts that have
 * gone over their time limit.
 *
 */
class mod_quiz_overdue_attempt_updater {

    /**
     * Do the processing required.
     * @param int $timenow the time to consider as 'now' during the processing.
     * @param int $processto only process attempt with timecheckstate longer ago than this.
     * @return array with two elements, the number of attempt considered, and how many different quizzes that was.
     */
    public function update_overdue_attempts($timenow, $processto) {
        global $DB;

        $attemptstoprocess = $this->get_list_of_overdue_attempts($processto);

        $course = null;
        $quiz = null;
        $cm = null;

        $count = 0;
        $quizcount = 0;
        foreach ($attemptstoprocess as $attempt) {
            try {

                // If we have moved on to a different quiz, fetch the new data.
                if (!$quiz || $attempt->quiz != $quiz->id) {
                    $quiz = $DB->get_record('quiz', array('id' => $attempt->quiz), '*', MUST_EXIST);
                    $cm = get_coursemodule_from_instance('quiz', $attempt->quiz);
                    $quizcount += 1;
                }

                // If we have moved on to a different course, fetch the new data.
                if (!$course || $course->id != $quiz->course) {
                    $course = $DB->get_record('course', array('id' => $quiz->course), '*', MUST_EXIST);
                }

                // Make a specialised version of the quiz settings, with the relevant overrides.
                $quizforuser = clone($quiz);
                $quizforuser->timeclose = $attempt->usertimeclose;
                $quizforuser->timelimit = $attempt->usertimelimit;

                // Trigger any transitions that are required.
                $attemptobj = new quiz_attempt($attempt, $quizforuser, $cm, $course);
                $attemptobj->handle_if_time_expired($timenow, false);
                $count += 1;

            } catch (lion_exception $e) {
                // If an error occurs while processing one attempt, don't let that kill cron.
                mtrace("Error while processing attempt {$attempt->id} at {$attempt->quiz} quiz:");
                mtrace($e->getMessage());
                mtrace($e->getTraceAsString());
                // Close down any currently open transactions, otherwise one error
                // will stop following DB changes from being committed.
                $DB->force_transaction_rollback();
            }
        }

        $attemptstoprocess->close();
        return array($count, $quizcount);
    }

    /**
     * @return lion_recordset of quiz_attempts that need to be processed because time has
     *     passed. The array is sorted by courseid then quizid.
     */
    public function get_list_of_overdue_attempts($processto) {
        global $DB;


        // SQL to compute timeclose and timelimit for each attempt:
        $quizausersql = quiz_get_attempt_usertime_sql(
                "iquiza.state IN ('inprogress', 'overdue') AND iquiza.timecheckstate <= :iprocessto");

        // This query should have all the quiz_attempts columns.
        return $DB->get_recordset_sql("
         SELECT quiza.*,
                quizauser.usertimeclose,
                quizauser.usertimelimit

           FROM {quiz_attempts} quiza
           JOIN {quiz} quiz ON quiz.id = quiza.quiz
           JOIN ( $quizausersql ) quizauser ON quizauser.id = quiza.id

          WHERE quiza.state IN ('inprogress', 'overdue')
            AND quiza.timecheckstate <= :processto
       ORDER BY quiz.course, quiza.quiz",

                array('processto' => $processto, 'iprocessto' => $processto));
    }
}
