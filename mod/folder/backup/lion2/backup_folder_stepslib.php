<?php


/**
 * Define all the backup steps that will be used by the backup_folder_activity_task
 *
 * @package    mod
 * @subpackage folder
 * @copyright 2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Define the complete folder structure for backup, with file and id annotations
 */
class backup_folder_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        // To know if we are including userinfo
        $userinfo = $this->get_setting_value('userinfo');

        // Define each element separated
        $folder = new backup_nested_element('folder', array('id'), array(
            'name', 'intro', 'introformat', 'revision',
            'timemodified', 'display', 'showexpanded'));

        // Build the tree
        // (nice mono-tree, lol)

        // Define sources
        $folder->set_source_table('folder', array('id' => backup::VAR_ACTIVITYID));

        // Define id annotations
        // (none)

        // Define file annotations
        $folder->annotate_files('mod_folder', 'intro', null);
        $folder->annotate_files('mod_folder', 'content', null);

        // Return the root element (folder), wrapped into standard activity structure
        return $this->prepare_activity_structure($folder);
    }
}
