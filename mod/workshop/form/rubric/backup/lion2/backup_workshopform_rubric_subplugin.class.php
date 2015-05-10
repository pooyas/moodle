<?php


/**
 * @package    workshopform
 * @subpackage rubric
 * @copyright  2015 Pooya Saeedi
 * 
 */
defined('LION_INTERNAL') || die();

/**
 * Provides the information to backup rubric grading strategy information
 */
class backup_workshopform_rubric_subplugin extends backup_subplugin {

    /**
     * Returns the assessment form definition to attach to 'workshop' XML element
     */
    protected function define_workshop_subplugin_structure() {

        // XML nodes declaration
        $subplugin = $this->get_subplugin_element(); // virtual optigroup element
        $subpluginwrapper = new backup_nested_element($this->get_recommended_name());
        $subpluginconfig = new backup_nested_element('workshopform_rubric_config', null, 'layout');
        $subplugindimension = new backup_nested_element('workshopform_rubric_dimension', array('id'), array(
            'sort', 'description', 'descriptionformat'));
        $subpluginlevel = new backup_nested_element('workshopform_rubric_level', array('id'), array(
            'grade', 'definition', 'definitionformat'));

        // connect XML elements into the tree
        $subplugin->add_child($subpluginwrapper);
        $subpluginwrapper->add_child($subpluginconfig);
        $subpluginwrapper->add_child($subplugindimension);
        $subplugindimension->add_child($subpluginlevel);

        // set source to populate the data
        $subpluginconfig->set_source_table('workshopform_rubric_config', array('workshopid' => backup::VAR_ACTIVITYID));
        $subplugindimension->set_source_table('workshopform_rubric', array('workshopid' => backup::VAR_ACTIVITYID));
        $subpluginlevel->set_source_table('workshopform_rubric_levels', array('dimensionid' => backup::VAR_PARENTID));

        // file annotations
        $subplugindimension->annotate_files('workshopform_rubric', 'description', 'id');

        return $subplugin;
    }

    /**
     * Returns the dimension grades to attach to 'referenceassessment' XML element
     */
    protected function define_referenceassessment_subplugin_structure() {
        return $this->dimension_grades_structure('workshopform_rubric_referencegrade');
    }

    /**
     * Returns the dimension grades to attach to 'exampleassessment' XML element
     */
    protected function define_exampleassessment_subplugin_structure() {
        return $this->dimension_grades_structure('workshopform_rubric_examplegrade');
    }

    /**
     * Returns the dimension grades to attach to 'assessment' XML element
     */
    protected function define_assessment_subplugin_structure() {
        return $this->dimension_grades_structure('workshopform_rubric_grade');
    }

    ////////////////////////////////////////////////////////////////////////////
    // internal private methods
    ////////////////////////////////////////////////////////////////////////////

    /**
     * Returns the structure of dimension grades
     *
     * @param string first parameter of {@link backup_nested_element} constructor
     */
    private function dimension_grades_structure($elementname) {

        // create XML elements
        $subplugin = $this->get_subplugin_element(); // virtual optigroup element
        $subpluginwrapper = new backup_nested_element($this->get_recommended_name());
        $subplugingrade = new backup_nested_element($elementname, array('id'), array(
            'dimensionid', 'grade'));

        // connect XML elements into the tree
        $subplugin->add_child($subpluginwrapper);
        $subpluginwrapper->add_child($subplugingrade);

        // set source to populate the data
        $subplugingrade->set_source_sql(
            "SELECT id, dimensionid, grade
               FROM {workshop_grades}
              WHERE strategy = 'rubric' AND assessmentid = ?",
              array(backup::VAR_PARENTID));

        return $subplugin;
    }
}
