<?php

/**
 * Defines backup_default_block_task class
 *
 * @package     core
 * @subpackage backup
 * @copyright   2015 Pooya Saeedi
 */

// Note:
// Renaming required

defined('MOODLE_INTERNAL') || die();

/**
 * Default block task to backup blocks that haven't own DB structures to be added
 * when one block is being backup
 *
 * TODO: Finish phpdocs
 */
class backup_default_block_task extends backup_block_task {
    // Nothing to do, it's just the backup_block_task in action
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

    static public function encode_content_links($content) {
        return $content;
    }
}

