<?php

/**
 * @package block
 * @subpackage glossary_random
 * @copyright 2015 Pooya Saeedi
 * 
 */

/**
 * Specialised restore task for the glossary_random block
 * (using execute_after_tasks for recoding of glossaryid)
 *
 * TODO: Finish phpdocs
 */
class restore_glossary_random_block_task extends restore_block_task {

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
     * target glossary for the block. This must be done here
     * and not in normal execution steps because the glossary
     * may be restored after the block.
     */
    public function after_restore() {
        global $DB;

        // Get the blockid
        $blockid = $this->get_blockid();

        // Extract block configdata and update it to point to the new glossary
        if ($configdata = $DB->get_field('block_instances', 'configdata', array('id' => $blockid))) {
            $config = unserialize(base64_decode($configdata));
            if (!empty($config->glossary)) {
                // Get glossary mapping and replace it in config
                if ($glossarymap = restore_dbops::get_backup_ids_record($this->get_restoreid(), 'glossary', $config->glossary)) {
                    $config->glossary = $glossarymap->newitemid;
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
