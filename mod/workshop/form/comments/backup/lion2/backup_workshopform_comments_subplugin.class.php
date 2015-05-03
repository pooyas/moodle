<?php


/**
 * @package    workshopform_comments
 * @copyright  2015 Pooya Saeedi
 * 
 */
defined('LION_INTERNAL') || die();

/**
 * Provides the information to backup comments grading strategy information
 */
class backup_workshopform_comments_subplugin extends backup_subplugin {

    /**
     * Returns the assessment form definition to attach to 'workshop' XML element
     */
    protected function define_workshop_subplugin_structure() {

        // XML nodes declaration
        $subplugin = $this->get_subplugin_element(); // virtual optigroup element
        $subpluginwrapper = new backup_nested_element($this->get_recommended_name());
        $subplugindimension = new backup_nested_element('workshopform_comments_dimension', array('id'), array(
            'sort', 'description', 'descriptionformat'));

        // connect XML elements into the tree
        $subplugin->add_child($subpluginwrapper);
        $subpluginwrapper->add_child($subplugindimension);

        // set source to populate the data
        $subplugindimension->set_source_table('workshopform_comments', array('workshopid' => backup::VAR_ACTIVITYID));

        // file annotations
        $subplugindimension->annotate_files('workshopform_comments', 'description', 'id');

        return $subplugin;
    }

    /**
     * Returns the dimension grades to attach to 'referenceassessment' XML element
     */
    protected function define_referenceassessment_subplugin_structure() {
        return $this->dimension_grades_structure('workshopform_comments_referencegrade');
    }

    /**
     * Returns the dimension grades to attach to 'exampleassessment' XML element
     */
    protected function define_exampleassessment_subplugin_structure() {
        return $this->dimension_grades_structure('workshopform_comments_examplegrade');
    }

    /**
     * Returns the dimension grades to attach to 'assessment' XML element
     */
    protected function define_assessment_subplugin_structure() {
        return $this->dimension_grades_structure('workshopform_comments_grade');
    }

    ////////////////////////////////////////////////////////////////////////////
    // internal private methods
    ////////////////////////////////////////////////////////////////////////////

    /**
     * Returns the structure of dimension grades
     *
     * @param string forst parameter of {@link backup_nested_element} constructor
     */
    private function dimension_grades_structure($elementname) {

        // create XML elements
        $subplugin = $this->get_subplugin_element(); // virtual optigroup element
        $subpluginwrapper = new backup_nested_element($this->get_recommended_name());
        $subplugingrade = new backup_nested_element($elementname, array('id'), array(
            'dimensionid', 'peercomment', 'peercommentformat'));

        // connect XML elements into the tree
        $subplugin->add_child($subpluginwrapper);
        $subpluginwrapper->add_child($subplugingrade);

        // set source to populate the data
        $subplugingrade->set_source_sql(
            "SELECT id, dimensionid, peercomment, peercommentformat
               FROM {workshop_grades}
              WHERE strategy = 'comments' AND assessmentid = ?",
              array(backup::VAR_PARENTID));

        return $subplugin;
    }
}
