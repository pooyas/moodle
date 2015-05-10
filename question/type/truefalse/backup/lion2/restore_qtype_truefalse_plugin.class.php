<?php

/**
 * @package    core
 * @subpackage backup-lion2
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * restore plugin class that provides the necessary information
 * needed to restore one truefalse qtype plugin
 *
 */
class restore_qtype_truefalse_plugin extends restore_qtype_plugin {

    /**
     * Returns the paths to be handled by the plugin at question level
     */
    protected function define_question_plugin_structure() {

        $paths = array();

        // This qtype uses question_answers, add them.
        $this->add_question_question_answers($paths);

        // Add own qtype stuff.
        $elename = 'truefalse';
        $elepath = $this->get_pathfor('/truefalse'); // We used get_recommended_name() so this works.
        $paths[] = new restore_path_element($elename, $elepath);

        return $paths; // And we return the interesting paths.
    }

    /**
     * Process the qtype/truefalse element
     */
    public function process_truefalse($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;

        // Detect if the question is created or mapped.
        $oldquestionid   = $this->get_old_parentid('question');
        $newquestionid   = $this->get_new_parentid('question');
        $questioncreated = $this->get_mappingid('question_created', $oldquestionid) ? true : false;

        // If the question has been created by restore, we need to create its question_truefalse too.
        if ($questioncreated) {
            // Adjust some columns.
            $data->question = $newquestionid;
            $data->trueanswer = $this->get_mappingid('question_answer', $data->trueanswer);
            $data->falseanswer = $this->get_mappingid('question_answer', $data->falseanswer);
            // Insert record.
            $newitemid = $DB->insert_record('question_truefalse', $data);
            // Create mapping.
            $this->set_mapping('question_truefalse', $oldid, $newitemid);
        }
    }

    /**
     * Given one question_states record, return the answer
     * recoded pointing to all the restored stuff for truefalse questions
     *
     * if not empty, answer is one question_answers->id
     */
    public function recode_legacy_state_answer($state) {
        $answer = $state->answer;
        $result = '';
        if ($answer) {
            $result = $this->get_mappingid('question_answer', $answer);
        }
        return $result;
    }
}
