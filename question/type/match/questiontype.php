<?php

/**
 * Question type class for the matching question type.
 *
 * @package   qtype
 * @subpackage match
 * @copyright 2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

require_once($CFG->libdir . '/questionlib.php');
require_once($CFG->dirroot . '/question/engine/lib.php');


/**
 * The matching question type class.
 *
 */
class qtype_match extends question_type {

    public function get_question_options($question) {
        global $DB;
        parent::get_question_options($question);
        $question->options = $DB->get_record('qtype_match_options',
                array('questionid' => $question->id));
        $question->options->subquestions = $DB->get_records('qtype_match_subquestions',
                array('questionid' => $question->id), 'id ASC');
        return true;
    }

    public function save_question_options($question) {
        global $DB;
        $context = $question->context;
        $result = new stdClass();

        $oldsubquestions = $DB->get_records('qtype_match_subquestions',
                array('questionid' => $question->id), 'id ASC');

        // Insert all the new question & answer pairs.
        foreach ($question->subquestions as $key => $questiontext) {
            if ($questiontext['text'] == '' && trim($question->subanswers[$key]) == '') {
                continue;
            }
            if ($questiontext['text'] != '' && trim($question->subanswers[$key]) == '') {
                $result->notice = get_string('nomatchinganswer', 'qtype_match', $questiontext);
            }

            // Update an existing subquestion if possible.
            $subquestion = array_shift($oldsubquestions);
            if (!$subquestion) {
                $subquestion = new stdClass();
                $subquestion->questionid = $question->id;
                $subquestion->questiontext = '';
                $subquestion->answertext = '';
                $subquestion->id = $DB->insert_record('qtype_match_subquestions', $subquestion);
            }

            $subquestion->questiontext = $this->import_or_save_files($questiontext,
                    $context, 'qtype_match', 'subquestion', $subquestion->id);
            $subquestion->questiontextformat = $questiontext['format'];
            $subquestion->answertext = trim($question->subanswers[$key]);

            $DB->update_record('qtype_match_subquestions', $subquestion);
        }

        // Delete old subquestions records.
        $fs = get_file_storage();
        foreach ($oldsubquestions as $oldsub) {
            $fs->delete_area_files($context->id, 'qtype_match', 'subquestion', $oldsub->id);
            $DB->delete_records('qtype_match_subquestions', array('id' => $oldsub->id));
        }

        // Save the question options.
        $options = $DB->get_record('qtype_match_options', array('questionid' => $question->id));
        if (!$options) {
            $options = new stdClass();
            $options->questionid = $question->id;
            $options->correctfeedback = '';
            $options->partiallycorrectfeedback = '';
            $options->incorrectfeedback = '';
            $options->id = $DB->insert_record('qtype_match_options', $options);
        }

        $options->shuffleanswers = $question->shuffleanswers;
        $options = $this->save_combined_feedback_helper($options, $question, $context, true);
        $DB->update_record('qtype_match_options', $options);

        $this->save_hints($question, true);

        if (!empty($result->notice)) {
            return $result;
        }

        return true;
    }

    protected function initialise_question_instance(question_definition $question, $questiondata) {
        parent::initialise_question_instance($question, $questiondata);

        $question->shufflestems = $questiondata->options->shuffleanswers;
        $this->initialise_combined_feedback($question, $questiondata, true);

        $question->stems = array();
        $question->choices = array();
        $question->right = array();

        foreach ($questiondata->options->subquestions as $matchsub) {
            $ans = $matchsub->answertext;
            $key = array_search($matchsub->answertext, $question->choices);
            if ($key === false) {
                $key = $matchsub->id;
                $question->choices[$key] = $matchsub->answertext;
            }

            if ($matchsub->questiontext !== '') {
                $question->stems[$matchsub->id] = $matchsub->questiontext;
                $question->stemformat[$matchsub->id] = $matchsub->questiontextformat;
                $question->right[$matchsub->id] = $key;
            }
        }
    }

    protected function make_hint($hint) {
        return question_hint_with_parts::load_from_record($hint);
    }

    public function delete_question($questionid, $contextid) {
        global $DB;
        $DB->delete_records('qtype_match_options', array('questionid' => $questionid));
        $DB->delete_records('qtype_match_subquestions', array('questionid' => $questionid));

        parent::delete_question($questionid, $contextid);
    }

    public function get_random_guess_score($questiondata) {
        $q = $this->make_question($questiondata);
        return 1 / count($q->choices);
    }

    public function get_possible_responses($questiondata) {
        $subqs = array();

        $q = $this->make_question($questiondata);

        foreach ($q->stems as $stemid => $stem) {

            $responses = array();
            foreach ($q->choices as $choiceid => $choice) {
                $responses[$choiceid] = new question_possible_response(
                        $q->html_to_text($stem, $q->stemformat[$stemid]) . ': ' . $choice,
                        ($choiceid == $q->right[$stemid]) / count($q->stems));
            }
            $responses[null] = question_possible_response::no_response();

            $subqs[$stemid] = $responses;
        }

        return $subqs;
    }

    public function move_files($questionid, $oldcontextid, $newcontextid) {
        global $DB;
        $fs = get_file_storage();

        parent::move_files($questionid, $oldcontextid, $newcontextid);

        $subquestionids = $DB->get_records_menu('qtype_match_subquestions',
                array('questionid' => $questionid), 'id', 'id,1');
        foreach ($subquestionids as $subquestionid => $notused) {
            $fs->move_area_files_to_new_context($oldcontextid,
                    $newcontextid, 'qtype_match', 'subquestion', $subquestionid);
        }

        $this->move_files_in_combined_feedback($questionid, $oldcontextid, $newcontextid);
        $this->move_files_in_hints($questionid, $oldcontextid, $newcontextid);
    }

    protected function delete_files($questionid, $contextid) {
        global $DB;
        $fs = get_file_storage();

        parent::delete_files($questionid, $contextid);

        $subquestionids = $DB->get_records_menu('qtype_match_subquestions',
                array('questionid' => $questionid), 'id', 'id,1');
        foreach ($subquestionids as $subquestionid => $notused) {
            $fs->delete_area_files($contextid, 'qtype_match', 'subquestion', $subquestionid);
        }

        $this->delete_files_in_combined_feedback($questionid, $contextid);
        $this->delete_files_in_hints($questionid, $contextid);
    }
}
