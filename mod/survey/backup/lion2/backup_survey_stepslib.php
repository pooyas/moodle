<?php


/**
 * @package    mod
 * @subpackage survey
 * @category backup-lion2
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Define all the backup steps that will be used by the backup_survey_activity_task
 */

/**
 * Define the complete survey structure for backup, with file and id annotations
 */
class backup_survey_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        // To know if we are including userinfo
        $userinfo = $this->get_setting_value('userinfo');

        // Define each element separated
        $survey = new backup_nested_element('survey', array('id'), array(
            'name', 'intro', 'introformat', 'template',
            'questions', 'days', 'timecreated', 'timemodified'));

        $answers = new backup_nested_element('answers');

        $answer = new backup_nested_element('answer', array('id'), array(
            'userid', 'question', 'time', 'answer1',
            'answer2'));

        $analysis = new backup_nested_element('analysis');

        $analys = new backup_nested_element('analys', array('id'), array(
            'userid', 'notes'));

        // Build the tree
        $survey->add_child($answers);
        $answers->add_child($answer);

        $survey->add_child($analysis);
        $analysis->add_child($analys);

        // Define sources
        $survey->set_source_table('survey', array('id' => backup::VAR_ACTIVITYID));

        $answer->set_source_table('survey_answers', array('survey' => backup::VAR_PARENTID));

        $analys->set_source_table('survey_analysis', array('survey' => backup::VAR_PARENTID));

        // Define id annotations
        $answer->annotate_ids('user', 'userid');
        $analys->annotate_ids('user', 'userid');

        // Define file annotations
        $survey->annotate_files('mod_survey', 'intro', null); // This file area hasn't itemid

        // Return the root element (survey), wrapped into standard activity structure
        return $this->prepare_activity_structure($survey);
    }
}
