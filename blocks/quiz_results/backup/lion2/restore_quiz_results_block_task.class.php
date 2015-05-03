<?php

/**
 * @package    block_quiz_results
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Specialised restore task for the quiz_results block
 * (using execute_after_tasks for recoding of target quiz)
 *
 * TODO: Finish phpdocs
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class restore_quiz_results_block_task extends restore_block_task {

    protected function define_my_settings() {
    }

    protected function define_my_steps() {
    }

    public function get_fileareas() {
        return array(); // No associated fileareas
    }

    public function get_configdata_encoded_attributes() {
        return array(); // No special handling of configdata
    }

    /**
     * This function, executed after all the tasks in the plan
     * have been executed, will perform the recode of the
     * target quiz for the block. This must be done here
     * and not in normal execution steps because the quiz
     * can be restored after the block.
     */
    public function after_restore() {
        global $DB;

        // Get the blockid
        $blockid = $this->get_blockid();

        // Extract block configdata and update it to point to the new quiz
        if ($configdata = $DB->get_field('block_instances', 'configdata', array('id' => $blockid))) {
            $config = unserialize(base64_decode($configdata));
            if (!empty($config->quizid)) {
                // Get quiz mapping and replace it in config
                if ($quizmap = restore_dbops::get_backup_ids_record($this->get_restoreid(), 'quiz', $config->quizid)) {
                    $config->quizid = $quizmap->newitemid;
                    $configdata = base64_encode(serialize($config));
                    $DB->set_field('block_instances', 'configdata', $configdata, array('id' => $blockid));
                }
            }
        }
    }

    static public function define_decode_contents() {
        return array();
    }

    static public function define_decode_rules() {
        return array();
    }
}
