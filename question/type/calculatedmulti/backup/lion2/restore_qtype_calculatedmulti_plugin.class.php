<?php


/**
 * @package    question_type
 * @subpackage calculatedmulti
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();


require_once($CFG->dirroot .
        '/question/type/calculated/backup/lion2/restore_qtype_calculated_plugin.class.php');

/**
 * restore plugin class that provides the necessary information
 * needed to restore one calculatedmulti qtype plugin.
 *
 */
class restore_qtype_calculatedmulti_plugin extends restore_qtype_calculated_plugin {

    public function recode_response($questionid, $sequencenumber, array $response) {
        return $this->step->questions_recode_response_data('multichoice',
                $questionid, $sequencenumber, $response);
    }

    /**
     * Given one question_states record, return the answer
     * recoded pointing to all the restored stuff for calculatedmulti questions
     *
     * answer format is datasetxx-yy:zz, where xx is the itemnumber in the dataset
     * (doesn't need conversion), and both yy and zz are two (hypen speparated)
     * lists of comma separated question_answers, the first to specify the order
     * of the answers and the second to specify the responses.
     *
     * in fact, this qtype behaves exactly like the multichoice one, so we'll delegate
     * recoding of those yy:zz to it
     */
    public function recode_legacy_state_answer($state) {
        $answer = $state->answer;
        $result = '';
        // Datasetxx-yy:zz format.
        if (preg_match('~^dataset([0-9]+)-(.*)$~', $answer, $matches)) {
            $itemid = $matches[1];
            $subanswer  = $matches[2];
            // Delegate subanswer recode to multichoice qtype, faking one question_states record.
            $substate = new stdClass();
            $substate->answer = $subanswer;
            $newanswer = $this->step->restore_recode_legacy_answer($substate, 'multichoice');
            $result = 'dataset' . $itemid . '-' . $newanswer;
        }
        return $result ? $result : $answer;
    }
}
