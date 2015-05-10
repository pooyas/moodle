<?php

/**
 * This file contains all the backup steps that will be used
 * by the backup_lti_activity_task
 *
 * @package mod
 * @subpackage lti
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

/**
 * Define the complete assignment structure for backup, with file and id annotations
 */
class backup_lti_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        // TODO: MDL-34161 - Fix restore to support course/site tools & submissions.

        // To know if we are including userinfo.
        $userinfo = $this->get_setting_value('userinfo');

        // Define each element separated.
        $lti = new backup_nested_element('lti', array('id'), array(
            'name',
            'intro',
            'introformat',
            'timecreated',
            'timemodified',
            'typeid',
            'toolurl',
            'securetoolurl',
            'preferheight',
            'launchcontainer',
            'instructorchoicesendname',
            'instructorchoicesendemailaddr',
            'instructorchoiceacceptgrades',
            'instructorchoiceallowroster',
            'instructorchoiceallowsetting',
            'grade',
            'instructorcustomparameters',
            'debuglaunch',
            'showtitlelaunch',
            'showdescriptionlaunch',
            'icon',
            'secureicon',
            )
        );

        // Build the tree
        // (none).

        // Define sources.
        $lti->set_source_table('lti', array('id' => backup::VAR_ACTIVITYID));

        // Define id annotations
        // (none).

        // Define file annotations.
        $lti->annotate_files('mod_lti', 'intro', null); // This file areas haven't itemid.

        // Add support for subplugin structures.
        $this->add_subplugin_structure('ltisource', $lti, true);
        $this->add_subplugin_structure('ltiservice', $lti, true);

        // Return the root element (lti), wrapped into standard activity structure.
        return $this->prepare_activity_structure($lti);
    }
}
