<?php


/**
 * @package    question_type
 * @subpackage shortanswer
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();


/**
 * Provides the information to backup shortanswer questions
 *
 */
class backup_qtype_shortanswer_plugin extends backup_qtype_plugin {

    /**
     * Returns the qtype information to attach to question element
     */
    protected function define_question_plugin_structure() {

        // Define the virtual plugin element with the condition to fulfill.
        $plugin = $this->get_plugin_element(null, '../../qtype', 'shortanswer');

        // Create one standard named plugin element (the visible container).
        $pluginwrapper = new backup_nested_element($this->get_recommended_name());

        // Connect the visible container ASAP.
        $plugin->add_child($pluginwrapper);

        // This qtype uses standard question_answers, add them here
        // to the tree before any other information that will use them.
        $this->add_question_question_answers($pluginwrapper);

        // Now create the qtype own structures.
        $shortanswer = new backup_nested_element('shortanswer', array('id'), array('usecase'));

        // Now the own qtype tree.
        $pluginwrapper->add_child($shortanswer);

        // Set source to populate the data.
        $shortanswer->set_source_table('qtype_shortanswer_options',
                array('questionid' => backup::VAR_PARENTID));

        // Don't need to annotate ids nor files.

        return $plugin;
    }
}
