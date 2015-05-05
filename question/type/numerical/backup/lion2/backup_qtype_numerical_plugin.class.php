<?php

/**
 * @package    core
 * @subpackage backup-lion2
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Provides the information to backup numerical questions
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class backup_qtype_numerical_plugin extends backup_qtype_plugin {

    /**
     * Returns the qtype information to attach to question element
     */
    protected function define_question_plugin_structure() {

        // Define the virtual plugin element with the condition to fulfill.
        $plugin = $this->get_plugin_element(null, '../../qtype', 'numerical');

        // Create one standard named plugin element (the visible container).
        $pluginwrapper = new backup_nested_element($this->get_recommended_name());

        // Connect the visible container ASAP.
        $plugin->add_child($pluginwrapper);

        // This qtype uses standard question_answers, add them here
        // to the tree before any other information that will use them.
        $this->add_question_question_answers($pluginwrapper);

        // This qtype uses standard numerical units, add them here.
        $this->add_question_numerical_units($pluginwrapper);

        // This qtype uses standard numerical options, add them here.
        $this->add_question_numerical_options($pluginwrapper);

        // Now create the qtype own structures.
        $numericalrecords = new backup_nested_element('numerical_records');
        $numericalrecord = new backup_nested_element('numerical_record', array('id'), array(
            'answer', 'tolerance'));

        // Now the own qtype tree.
        $pluginwrapper->add_child($numericalrecords);
        $numericalrecords->add_child($numericalrecord);

        // Set source to populate the data.
        $numericalrecord->set_source_table('question_numerical',
                array('question' => backup::VAR_PARENTID));

        // Don't need to annotate ids nor files.

        return $plugin;
    }
}
