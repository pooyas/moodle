<?php


/**
 * Support for backup API
 *
 * @package    grade
 * @subpackage grading
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Defines marking guide backup structures
 *
 */
class backup_gradingform_guide_plugin extends backup_gradingform_plugin {

    /**
     * Declares marking guide structures to append to the grading form definition
     * @return backup_plugin_element
     */
    protected function define_definition_plugin_structure() {

        // Append data only if the grand-parent element has 'method' set to 'guide'.
        $plugin = $this->get_plugin_element(null, '../../method', 'guide');

        // Create a visible container for our data.
        $pluginwrapper = new backup_nested_element($this->get_recommended_name());

        // Connect our visible container to the parent.
        $plugin->add_child($pluginwrapper);

        // Define our elements.

        $criteria = new backup_nested_element('guidecriteria');

        $criterion = new backup_nested_element('guidecriterion', array('id'), array(
            'sortorder', 'shortname', 'description', 'descriptionformat',
            'descriptionmarkers', 'descriptionmarkersformat', 'maxscore'));

        $comments = new backup_nested_element('guidecomments');

        $comment = new backup_nested_element('guidecomment', array('id'), array(
            'sortorder', 'description', 'descriptionformat'));

        // Build elements hierarchy.

        $pluginwrapper->add_child($criteria);
        $criteria->add_child($criterion);
        $pluginwrapper->add_child($comments);
        $comments->add_child($comment);

        // Set sources to populate the data.

        $criterion->set_source_table('gradingform_guide_criteria',
                array('definitionid' => backup::VAR_PARENTID));

        $comment->set_source_table('gradingform_guide_comments',
                array('definitionid' => backup::VAR_PARENTID));

        // No need to annotate ids or files yet (one day when criterion definition supports
        // embedded files, they must be annotated here).

        return $plugin;
    }

    /**
     * Declares marking guide structures to append to the grading form instances
     * @return backup_plugin_element
     */
    protected function define_instance_plugin_structure() {

        // Append data only if the ancestor 'definition' element has 'method' set to 'guide'.
        $plugin = $this->get_plugin_element(null, '../../../../method', 'guide');

        // Create a visible container for our data.
        $pluginwrapper = new backup_nested_element($this->get_recommended_name());

        // Connect our visible container to the parent.
        $plugin->add_child($pluginwrapper);

        // Define our elements.

        $fillings = new backup_nested_element('fillings');

        $filling = new backup_nested_element('filling', array('id'), array(
            'criterionid', 'remark', 'remarkformat', 'score'));

        // Build elements hierarchy.

        $pluginwrapper->add_child($fillings);
        $fillings->add_child($filling);

        // Set sources to populate the data.

        $filling->set_source_table('gradingform_guide_fillings',
            array('instanceid' => backup::VAR_PARENTID));

        // No need to annotate ids or files yet (one day when remark field supports
        // embedded fileds, they must be annotated here).

        return $plugin;
    }
}
