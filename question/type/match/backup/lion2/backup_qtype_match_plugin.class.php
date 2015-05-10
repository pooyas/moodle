<?php

/**
 * @package    core
 * @subpackage backup-lion2
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Provides the information to backup match questions.
 *
 */
class backup_qtype_match_plugin extends backup_qtype_plugin {

    /**
     * Returns the qtype information to attach to question element.
     */
    protected function define_question_plugin_structure() {

        // Define the virtual plugin element with the condition to fulfill.
        $plugin = $this->get_plugin_element(null, '../../qtype', 'match');

        // Create one standard named plugin element (the visible container).
        $pluginwrapper = new backup_nested_element($this->get_recommended_name());

        // Connect the visible container ASAP.
        $plugin->add_child($pluginwrapper);

        // Now create the qtype own structures.
        $matchoptions = new backup_nested_element('matchoptions', array('id'), array(
            'shuffleanswers', 'correctfeedback', 'correctfeedbackformat',
            'partiallycorrectfeedback', 'partiallycorrectfeedbackformat',
            'incorrectfeedback', 'incorrectfeedbackformat', 'shownumcorrect'));

        $matches = new backup_nested_element('matches');

        $match = new backup_nested_element('match', array('id'), array(
            'questiontext', 'questiontextformat', 'answertext'));

        // Now the own qtype tree.
        $pluginwrapper->add_child($matchoptions);
        $pluginwrapper->add_child($matches);
        $matches->add_child($match);

        // Set source to populate the data.
        $matchoptions->set_source_table('qtype_match_options',
                array('questionid' => backup::VAR_PARENTID));
        $match->set_source_table('qtype_match_subquestions', array('questionid' => backup::VAR_PARENTID), 'id ASC');

        // Don't need to annotate ids nor files.

        return $plugin;
    }

    /**
     * Returns one array with filearea => mappingname elements for the qtype.
     *
     * Used by {@link get_components_and_fileareas} to know about all the qtype
     * files to be processed both in backup and restore.
     */
    public static function get_qtype_fileareas() {
        return array(
            'subquestion' => 'qtype_match_subquestions');
    }
}
