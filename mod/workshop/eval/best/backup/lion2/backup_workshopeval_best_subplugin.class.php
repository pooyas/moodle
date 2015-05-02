<?php


/**
 * @package    workshopeval
 * @subpackage best
 * @copyright  2010 David Mudrak <david@lion.com>
 * 
 */
defined('LION_INTERNAL') || die();

/**
 * Provides the information to backup grading evaluation method 'Comparison with the best assessment'
 *
 * This evaluator just stores a single integer value - the recently used comparison
 * strictness factor. It adds its XML data to workshop tag.
 */
class backup_workshopeval_best_subplugin extends backup_subplugin {

    /**
     * Returns the subplugin information to attach to workshop element
     */
    protected function define_workshop_subplugin_structure() {

        // create XML elements
        $subplugin = $this->get_subplugin_element(); // virtual optigroup element
        $subplugin_wrapper = new backup_nested_element($this->get_recommended_name());
        $subplugin_table_settings = new backup_nested_element('workshopeval_best_settings', null, array('comparison'));

        // connect XML elements into the tree
        $subplugin->add_child($subplugin_wrapper);
        $subplugin_wrapper->add_child($subplugin_table_settings);

        // set source to populate the data
        $subplugin_table_settings->set_source_table('workshopeval_best_settings', array('workshopid' => backup::VAR_ACTIVITYID));

        return $subplugin;
    }
}
