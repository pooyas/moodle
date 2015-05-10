<?php

/**
 * This file contains the backup code for the feedback_file plugin.
 *
 * @package   assignfeedback
 * @subpackage file
 * @copyright 2015 Pooya Saeedi 
 * 
 */
defined('LION_INTERNAL') || die();

/**
 * Provides the information to backup feedback files.
 *
 * This just adds its filearea to the annotations and records the number of files.
 *
 */
class backup_assignfeedback_file_subplugin extends backup_subplugin {

    /**
     * Returns the subplugin information to attach to feedback element
     * @return backup_subplugin_element
     */
    protected function define_grade_subplugin_structure() {

        // Create XML elements.
        $subplugin = $this->get_subplugin_element();
        $subpluginwrapper = new backup_nested_element($this->get_recommended_name());
        $subpluginelement = new backup_nested_element('feedback_file', null, array('numfiles', 'grade'));

        // Connect XML elements into the tree.
        $subplugin->add_child($subpluginwrapper);
        $subpluginwrapper->add_child($subpluginelement);

        // Set source to populate the data.
        $subpluginelement->set_source_table('assignfeedback_file', array('grade' => backup::VAR_PARENTID));
        // The parent is the grade.
        $subpluginelement->annotate_files('assignfeedback_file', 'feedback_files', 'grade');
        return $subplugin;
    }

}
