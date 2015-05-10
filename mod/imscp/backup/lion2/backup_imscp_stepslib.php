<?php

/**
 * Define all the backup steps that will be used by the backup_imscp_activity_task
 *
 * @package mod
 * @subpackage imscp
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Define the complete imscp structure for backup, with file and id annotations
 *
 */
class backup_imscp_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        // To know if we are including userinfo.
        $userinfo = $this->get_setting_value('userinfo');

        // Define each element separated.
        $imscp = new backup_nested_element('imscp', array('id'), array(
            'name', 'intro', 'introformat', 'revision',
            'keepold', 'structure', 'timemodified'));

        // Build the tree.

        // Define sources.
        $imscp->set_source_table('imscp', array('id' => backup::VAR_ACTIVITYID));

        // Define id annotations - (none).

        // Define file annotations
        $imscp->annotate_files('mod_imscp', 'intro', null); // This file area hasn't itemid.
        $imscp->annotate_files('mod_imscp', 'backup', null); // This file area hasn't itemid.
        // Eloy Lafuente: I don't like itemid used for "imaginative" things like "revisions"!
        $imscp->annotate_files('mod_imscp', 'content', null); // Horrible use of itemid here. Ignoring for backup/restore purposes.

        // Return the root element (imscp), wrapped into standard activity structure.
        return $this->prepare_activity_structure($imscp);
    }
}
