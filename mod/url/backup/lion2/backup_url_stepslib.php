<?php



/**
 * Define all the backup steps that will be used by the backup_url_activity_task
 *
 * @package    mod
 * @subpackage url
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

 /**
 * Define the complete url structure for backup, with file and id annotations
 */
class backup_url_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        //the URL module stores no user info

        // Define each element separated
        $url = new backup_nested_element('url', array('id'), array(
            'name', 'intro', 'introformat', 'externalurl',
            'display', 'displayoptions', 'parameters', 'timemodified'));


        // Build the tree
        //nothing here for URLs

        // Define sources
        $url->set_source_table('url', array('id' => backup::VAR_ACTIVITYID));

        // Define id annotations
        //module has no id annotations

        // Define file annotations
        $url->annotate_files('mod_url', 'intro', null); // This file area hasn't itemid

        // Return the root element (url), wrapped into standard activity structure
        return $this->prepare_activity_structure($url);

    }
}
