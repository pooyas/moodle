<?php


/**
 * Defines restore_default_block_task class
 *
 * @package     core_backup
 * @subpackage  lion2
 * @category    backup
 * @copyright   2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Default block task to restore blocks not having own DB structures to be added
 *
 * TODO: Finish phpdocs
 */
class restore_default_block_task extends restore_block_task {
    // Nothing to do, it's just the restore_block_task in action
    // with required methods doing nothing special

    protected function define_my_settings() {
    }

    protected function define_my_steps() {
    }

    public function get_fileareas() {
        return array();
    }

    public function get_configdata_encoded_attributes() {
        return array();
    }

    static public function define_decode_contents() {
        return array();
    }

    static public function define_decode_rules() {
        return array();
    }
}

