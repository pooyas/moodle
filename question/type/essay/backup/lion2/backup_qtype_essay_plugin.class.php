<?php

/**
 * @package    lioncore
 * @subpackage backup-lion2
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Provides the information to backup essay questions
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class backup_qtype_essay_plugin extends backup_qtype_plugin {

    /**
     * Returns the qtype information to attach to question element
     */
    protected function define_question_plugin_structure() {

        // Define the virtual plugin element with the condition to fulfill.
        $plugin = $this->get_plugin_element(null, '../../qtype', 'essay');

        // Create one standard named plugin element (the visible container).
        $pluginwrapper = new backup_nested_element($this->get_recommended_name());

        // Connect the visible container ASAP.
        $plugin->add_child($pluginwrapper);

        // Now create the qtype own structures.
        $essay = new backup_nested_element('essay', array('id'), array(
                'responseformat', 'responserequired', 'responsefieldlines',
                'attachments', 'attachmentsrequired', 'graderinfo',
                'graderinfoformat', 'responsetemplate', 'responsetemplateformat'));

        // Now the own qtype tree.
        $pluginwrapper->add_child($essay);

        // Set source to populate the data.
        $essay->set_source_table('qtype_essay_options',
                array('questionid' => backup::VAR_PARENTID));

        // Don't need to annotate ids nor files.

        return $plugin;
    }

    /**
     * Returns one array with filearea => mappingname elements for the qtype
     *
     * Used by {@link get_components_and_fileareas} to know about all the qtype
     * files to be processed both in backup and restore.
     */
    public static function get_qtype_fileareas() {
        return array(
            'graderinfo' => 'question_created',
        );
    }
}
