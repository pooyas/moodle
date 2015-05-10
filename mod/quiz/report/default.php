<?php

/**
 * Base class for quiz report plugins.
 *
 * @package   mod
 * @subpackage quiz
 * @copyright 2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Base class for quiz report plugins.
 *
 * Doesn't do anything on it's own -- it needs to be extended.
 * This class displays quiz reports.  Because it is called from
 * within /mod/quiz/report.php you can assume that the page header
 * and footer are taken care of.
 *
 * This file can refer to itself as report.php to pass variables
 * to itself - all these will also be globally available.  You must
 * pass "id=$cm->id" or q=$quiz->id", and "mode=reportname".
 *
 */
abstract class quiz_default_report {
    const NO_GROUPS_ALLOWED = -2;

    /**
     * Override this function to displays the report.
     * @param $cm the course-module for this quiz.
     * @param $course the coures we are in.
     * @param $quiz this quiz.
     */
    public abstract function display($cm, $course, $quiz);

    /**
     * Initialise some parts of $PAGE and start output.
     *
     * @param object $cm the course_module information.
     * @param object $coures the course settings.
     * @param object $quiz the quiz settings.
     * @param string $reportmode the report name.
     */
    public function print_header_and_tabs($cm, $course, $quiz, $reportmode = 'overview') {
        global $PAGE, $OUTPUT;

        // Print the page header.
        $PAGE->set_title($quiz->name);
        $PAGE->set_heading($course->fullname);
        echo $OUTPUT->header();
        $context = context_module::instance($cm->id);
        echo $OUTPUT->heading(format_string($quiz->name, true, array('context' => $context)));
    }

    /**
     * Get the current group for the user user looking at the report.
     *
     * @param object $cm the course_module information.
     * @param object $coures the course settings.
     * @param context $context the quiz context.
     * @return int the current group id, if applicable. 0 for all users,
     *      NO_GROUPS_ALLOWED if the user cannot see any group.
     */
    public function get_current_group($cm, $course, $context) {
        $groupmode = groups_get_activity_groupmode($cm, $course);
        $currentgroup = groups_get_activity_group($cm, true);

        if ($groupmode == SEPARATEGROUPS && !$currentgroup && !has_capability('lion/site:accessallgroups', $context)) {
            $currentgroup = self::NO_GROUPS_ALLOWED;
        }

        return $currentgroup;
    }
}
