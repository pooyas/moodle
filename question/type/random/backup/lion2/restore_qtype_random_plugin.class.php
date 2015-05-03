<?php

/**
 * @package    lioncore
 * @subpackage backup-lion2
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * restore plugin class that provides the necessary information
 * needed to restore one random qtype plugin
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class restore_qtype_random_plugin extends restore_qtype_plugin {

    /**
     * Define the plugin structure.
     *
     * @return array  Array of {@link restore_path_elements}.
     */
    protected function define_question_plugin_structure() {
        $paths = array();

        // We have to specify a path here if we want after_execute_question to be called.
        $elename = 'donothing';
        $elepath = $this->get_pathfor('/');

        $paths[] = new restore_path_element($elename, $elepath);

        return $paths; // And we return the interesting paths.
    }

    /**
     * Required function to process path. Should never be called.
     *
     * @param object $data Data elements.
     */
    public function process_donothing($data) {
        // Intentionally blank.
    }

    /**
     * Given one question_states record, return the answer
     * recoded pointing to all the restored stuff for random questions
     *
     * answer format is randomxx-yy, with xx being question->id and
     * yy the actual response to the question. We'll delegate the recode
     * to the corresponding qtype
     *
     * also, some old states can contain, simply, one question->id,
     * support them, just in case
     */
    public function recode_legacy_state_answer($state) {
        global $DB;

        $answer = $state->answer;
        $result = '';
        // Randomxx-yy answer format.
        if (preg_match('~^random([0-9]+)-(.*)$~', $answer, $matches)) {
            $questionid = $matches[1];
            $subanswer  = $matches[2];
            $newquestionid = $this->get_mappingid('question', $questionid);
            $questionqtype = $DB->get_field('question', 'qtype', array('id' => $newquestionid));
            // Delegate subanswer recode to proper qtype, faking one question_states record.
            $substate = new stdClass();
            $substate->question = $newquestionid;
            $substate->answer = $subanswer;
            $newanswer = $this->step->restore_recode_legacy_answer($substate, $questionqtype);
            $result = 'random' . $newquestionid . '-' . $newanswer;

            // Simple question id format.
        } else {
            $newquestionid = $this->get_mappingid('question', $answer);
            $result = $newquestionid;
        }
        return $result;
    }

    /**
     * After restoring, make sure questiontext is set properly.
     */
    public function after_execute_question() {
        global $DB;

        // Update any blank random questiontexts to 0.
        $sql = "UPDATE {question}
                   SET questiontext = '0'
                 WHERE qtype = 'random'
                   AND " . $DB->sql_compare_text('questiontext') . " = ?
                   AND id IN (SELECT bi.newitemid
                                FROM {backup_ids_temp} bi
                               WHERE bi.backupid = ?
                                 AND bi.itemname = 'question_created')";

        $DB->execute($sql, array('', $this->get_restoreid()));
    }
}
