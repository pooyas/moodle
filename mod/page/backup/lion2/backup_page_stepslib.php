<?php


/**
 * @package   mod_page
 * @category  backup
 * @copyright 2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 */

defined('LION_INTERNAL') || die;

/**
 * Define all the backup steps that will be used by the backup_page_activity_task
 */

/**
 * Define the complete page structure for backup, with file and id annotations
 */
class backup_page_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        // To know if we are including userinfo
        $userinfo = $this->get_setting_value('userinfo');

        // Define each element separated
        $page = new backup_nested_element('page', array('id'), array(
            'name', 'intro', 'introformat', 'content', 'contentformat',
            'legacyfiles', 'legacyfileslast', 'display', 'displayoptions',
            'revision', 'timemodified'));

        // Build the tree
        // (love this)

        // Define sources
        $page->set_source_table('page', array('id' => backup::VAR_ACTIVITYID));

        // Define id annotations
        // (none)

        // Define file annotations
        $page->annotate_files('mod_page', 'intro', null); // This file areas haven't itemid
        $page->annotate_files('mod_page', 'content', null); // This file areas haven't itemid

        // Return the root element (page), wrapped into standard activity structure
        return $this->prepare_activity_structure($page);
    }
}
