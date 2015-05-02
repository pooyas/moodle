<?php

/**
 * This page allows the teacher to enter a manual grade for a particular question.
 * This page is expected to only be used in a popup window.
 *
 * @package   mod_quiz
 * @copyright gustav delius 2006
 * 
 */

require_once('../../config.php');
require_once('locallib.php');

$attemptid = required_param('attempt', PARAM_INT);
$slot = required_param('slot', PARAM_INT); // The question number in the attempt.

$PAGE->set_url('/mod/quiz/comment.php', array('attempt' => $attemptid, 'slot' => $slot));

$attemptobj = quiz_attempt::create($attemptid);

// Can only grade finished attempts.
if (!$attemptobj->is_finished()) {
    print_error('attemptclosed', 'quiz');
}

// Check login and permissions.
require_login($attemptobj->get_course(), false, $attemptobj->get_cm());
$attemptobj->require_capability('mod/quiz:grade');

// Print the page header.
$PAGE->set_pagelayout('popup');
$PAGE->set_heading($attemptobj->get_course()->fullname);
$output = $PAGE->get_renderer('mod_quiz');
echo $output->header();

// Prepare summary information about this question attempt.
$summarydata = array();

// Quiz name.
$summarydata['quizname'] = array(
    'title'   => get_string('modulename', 'quiz'),
    'content' => format_string($attemptobj->get_quiz_name()),
);

// Question name.
$summarydata['questionname'] = array(
    'title'   => get_string('question', 'quiz'),
    'content' => $attemptobj->get_question_name($slot),
);

// Process any data that was submitted.
if (data_submitted() && confirm_sesskey()) {
    if (optional_param('submit', false, PARAM_BOOL) && question_engine::is_manual_grade_in_range($attemptobj->get_uniqueid(), $slot)) {
        $transaction = $DB->start_delegated_transaction();
        $attemptobj->process_submitted_actions(time());
        $transaction->allow_commit();

        // Log this action.
        $params = array(
            'objectid' => $attemptobj->get_question_attempt($slot)->get_question()->id,
            'courseid' => $attemptobj->get_courseid(),
            'context' => context_module::instance($attemptobj->get_cmid()),
            'other' => array(
                'quizid' => $attemptobj->get_quizid(),
                'attemptid' => $attemptobj->get_attemptid(),
                'slot' => $slot
            )
        );
        $event = \mod_quiz\event\question_manually_graded::create($params);
        $event->trigger();

        echo $output->notification(get_string('changessaved'), 'notifysuccess');
        close_window(2, true);
        die;
    }
}

// Print quiz information.
echo $output->review_summary_table($summarydata, 0);

// Print the comment form.
echo '<form method="post" class="mform" id="manualgradingform" action="' .
        $CFG->wwwroot . '/mod/quiz/comment.php">';
echo $attemptobj->render_question_for_commenting($slot);
?>
<div>
    <input type="hidden" name="attempt" value="<?php echo $attemptobj->get_attemptid(); ?>" />
    <input type="hidden" name="slot" value="<?php echo $slot; ?>" />
    <input type="hidden" name="slots" value="<?php echo $slot; ?>" />
    <input type="hidden" name="sesskey" value="<?php echo sesskey(); ?>" />
</div>
<fieldset class="hidden">
    <div>
        <div class="fitem fitem_actionbuttons fitem_fsubmit">
            <fieldset class="felement fsubmit">
                <input id="id_submitbutton" type="submit" name="submit" value="<?php
                        print_string('save', 'quiz'); ?>"/>
            </fieldset>
        </div>
    </div>
</fieldset>
<?php
echo '</form>';
$PAGE->requires->js_init_call('M.mod_quiz.init_comment_popup', null, false, quiz_get_js_module());

// End of the page.
echo $output->footer();
