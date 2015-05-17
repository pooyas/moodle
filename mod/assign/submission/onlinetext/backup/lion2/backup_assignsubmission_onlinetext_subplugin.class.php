<?php


/**
 * This file contains the class for backup of this submission plugin
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Provides the information to backup onlinetext submissions
 *
 * This just adds its filearea to the annotations and records the submissiontext and format
 *
 */
class backup_assignsubmission_onlinetext_subplugin extends backup_subplugin {

    /**
     * Returns the subplugin information to attach to submission element
     *
     * @return backup_subplugin_element
     */
    protected function define_submission_subplugin_structure() {

        // Create XML elements.
        $subplugin = $this->get_subplugin_element();
        $subpluginwrapper = new backup_nested_element($this->get_recommended_name());
        $subpluginelement = new backup_nested_element('submission_onlinetext',
                                                      null,
                                                      array('onlinetext', 'onlineformat', 'submission'));

        // Connect XML elements into the tree.
        $subplugin->add_child($subpluginwrapper);
        $subpluginwrapper->add_child($subpluginelement);

        // Set source to populate the data.
        $subpluginelement->set_source_table('assignsubmission_onlinetext',
                                          array('submission' => backup::VAR_PARENTID));

        $subpluginelement->annotate_files('assignsubmission_onlinetext',
                                          'submissions_onlinetext',
                                          'submission');
        return $subplugin;
    }

}
