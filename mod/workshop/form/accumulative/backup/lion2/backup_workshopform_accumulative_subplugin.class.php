<?php


/**
 * @package    workshopform_accumulative
 * @copyright  2015 Pooya Saeedi
 * 
 */
defined('LION_INTERNAL') || die();

/**
 * Provides the information to backup accumulative grading strategy information
 */
class backup_workshopform_accumulative_subplugin extends backup_subplugin {

    /**
     * Returns the assessment form definition to attach to 'workshop' XML element
     */
    protected function define_workshop_subplugin_structure() {

        // XML nodes declaration
        $subplugin = $this->get_subplugin_element(); // virtual optigroup element
        $subpluginwrapper = new backup_nested_element($this->get_recommended_name());
        $subplugindimension = new backup_nested_element('workshopform_accumulative_dimension', array('id'), array(
            'sort', 'description', 'descriptionformat', 'grade', 'weight'));

        // connect XML elements into the tree
        $subplugin->add_child($subpluginwrapper);
        $subpluginwrapper->add_child($subplugindimension);

        // set source to populate the data
        $subplugindimension->set_source_table('workshopform_accumulative', array('workshopid' => backup::VAR_ACTIVITYID));

        // id annotations
        $subplugindimension->annotate_ids('scale', 'grade');

        // file annotations
        $subplugindimension->annotate_files('workshopform_accumulative', 'description', 'id');

        return $subplugin;
    }

    /**
     * Returns the dimension grades to attach to 'referenceassessment' XML element
     */
    protected function define_referenceassessment_subplugin_structure() {
        return $this->dimension_grades_structure('workshopform_accumulative_referencegrade');
    }

    /**
     * Returns the dimension grades to attach to 'exampleassessment' XML element
     */
    protected function define_exampleassessment_subplugin_structure() {
        return $this->dimension_grades_structure('workshopform_accumulative_examplegrade');
    }

    /**
     * Returns the dimension grades to attach to 'assessment' XML element
     */
    protected function define_assessment_subplugin_structure() {
        return $this->dimension_grades_structure('workshopform_accumulative_grade');
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
            'dimensionid', 'grade', 'peercomment', 'peercommentformat'));

        // connect XML elements into the tree
        $subplugin->add_child($subpluginwrapper);
        $subpluginwrapper->add_child($subplugingrade);

        // set source to populate the data
        $subplugingrade->set_source_sql(
            "SELECT id, dimensionid, grade, peercomment, peercommentformat
               FROM {workshop_grades}
              WHERE strategy = 'accumulative' AND assessmentid = ?",
              array(backup::VAR_PARENTID));

        return $subplugin;
    }
}
