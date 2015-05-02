<?php

/**
 * @package    lioncore
 * @subpackage backup-lion2
 * @copyright  2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Provides the information to backup randomsamatch questions
 *
 * @copyright  2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 */
class backup_qtype_randomsamatch_plugin extends backup_qtype_plugin {

    /**
     * Returns the qtype information to attach to question element
     */
    protected function define_question_plugin_structure() {

        // Define the virtual plugin element with the condition to fulfill.
        $plugin = $this->get_plugin_element(null, '../../qtype', 'randomsamatch');

        // Create one standard named plugin element (the visible container).
        $pluginwrapper = new backup_nested_element($this->get_recommended_name());

        // Connect the visible container ASAP.
        $plugin->add_child($pluginwrapper);

        // Now create the qtype own structures.
        $randomsamatch = new backup_nested_element('randomsamatch', array('id'), array(
            'choose', 'subcats', 'correctfeedback', 'correctfeedbackformat',
            'partiallycorrectfeedback', 'partiallycorrectfeedbackformat',
            'incorrectfeedback', 'incorrectfeedbackformat', 'shownumcorrect'));

        // Now the own qtype tree.
        $pluginwrapper->add_child($randomsamatch);

        // Set source to populate the data.
        $randomsamatch->set_source_table('qtype_randomsamatch_options',
                array('questionid' => backup::VAR_PARENTID));

        return $plugin;
    }
}
