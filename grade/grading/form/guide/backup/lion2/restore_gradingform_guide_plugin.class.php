<?php


/**
 * Support for restore API
 *
 * @package    grade
 * @subpackage grading
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Restores the marking guide specific data from grading.xml file
 *
 */
class restore_gradingform_guide_plugin extends restore_gradingform_plugin {

    /**
     * Declares the marking guide XML paths attached to the form definition element
     *
     * @return array of {@link restore_path_element}
     */
    protected function define_definition_plugin_structure() {

        $paths = array();

        $paths[] = new restore_path_element('gradingform_guide_criterion',
            $this->get_pathfor('/guidecriteria/guidecriterion'));

        $paths[] = new restore_path_element('gradingform_guide_comment',
            $this->get_pathfor('/guidecomments/guidecomment'));

        // MDL-37714: Correctly locate frequent used comments in both the
        // current and incorrect old format.
        $paths[] = new restore_path_element('gradingform_guide_comment_legacy',
            $this->get_pathfor('/guidecriteria/guidecomments/guidecomment'));

        return $paths;
    }

    /**
     * Declares the marking guide XML paths attached to the form instance element
     *
     * @return array of {@link restore_path_element}
     */
    protected function define_instance_plugin_structure() {

        $paths = array();

        $paths[] = new restore_path_element('gradinform_guide_filling',
            $this->get_pathfor('/fillings/filling'));

        return $paths;
    }

    /**
     * Processes criterion element data
     *
     * Sets the mapping 'gradingform_guide_criterion' to be used later by
     * {@link self::process_gradinform_guide_filling()}
     *
     * @param array|stdClass $data
     */
    public function process_gradingform_guide_criterion($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->definitionid = $this->get_new_parentid('grading_definition');

        $newid = $DB->insert_record('gradingform_guide_criteria', $data);
        $this->set_mapping('gradingform_guide_criterion', $oldid, $newid);
    }

    /**
     * Processes comments element data
     *
     * @param array|stdClass $data The data to insert as a comment
     */
    public function process_gradingform_guide_comment($data) {
        global $DB;

        $data = (object)$data;
        $data->definitionid = $this->get_new_parentid('grading_definition');

        $DB->insert_record('gradingform_guide_comments', $data);
    }

    /**
     * Processes comments element data
     *
     * @param array|stdClass $data The data to insert as a comment
     */
    public function process_gradingform_guide_comment_legacy($data) {
        global $DB;

        $data = (object)$data;
        $data->definitionid = $this->get_new_parentid('grading_definition');

        $DB->insert_record('gradingform_guide_comments', $data);
    }

    /**
     * Processes filling element data
     *
     * @param array|stdClass $data The data to insert as a filling
     */
    public function process_gradinform_guide_filling($data) {
        global $DB;

        $data = (object)$data;
        $data->instanceid = $this->get_new_parentid('grading_instance');
        $data->criterionid = $this->get_mappingid('gradingform_guide_criterion', $data->criterionid);

        $DB->insert_record('gradingform_guide_fillings', $data);
    }
}
