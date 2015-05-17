<?php



/**
 * @package    mod
 * @subpackage label
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Define all the backup steps that will be used by the backup_label_activity_task
 */

/**
 * Define the complete label structure for backup, with file and id annotations
 */
class backup_label_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        // To know if we are including userinfo
        $userinfo = $this->get_setting_value('userinfo');

        // Define each element separated
        $label = new backup_nested_element('label', array('id'), array(
            'name', 'intro', 'introformat', 'timemodified'));

        // Build the tree
        // (love this)

        // Define sources
        $label->set_source_table('label', array('id' => backup::VAR_ACTIVITYID));

        // Define id annotations
        // (none)

        // Define file annotations
        $label->annotate_files('mod_label', 'intro', null); // This file area hasn't itemid

        // Return the root element (label), wrapped into standard activity structure
        return $this->prepare_activity_structure($label);
    }
}
