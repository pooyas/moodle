<?php

/**
 * This file contains all the restore steps that will be used
 * by the restore_lti_activity_task
 *
 * @package mod
 * @subpackage lti
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

/**
 * Structure step to restore one lti activity
 */
class restore_lti_activity_structure_step extends restore_activity_structure_step {

    protected function define_structure() {

        $paths = array();
        $lti = new restore_path_element('lti', '/activity/lti');
        $paths[] = $lti;

        // Add support for subplugin structures.
        $this->add_subplugin_structure('ltisource', $lti);
        $this->add_subplugin_structure('ltiservice', $lti);

        // Return the paths wrapped into standard activity structure.
        return $this->prepare_activity_structure($paths);
    }

    protected function process_lti($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();
        $data->servicesalt = uniqid('', true);

         // Grade used to be a float (whole numbers only), restore as int.
        $data->grade = (int) $data->grade;

        // Clean any course or site typeid. All modules
        // are restored as self-contained. Note this is
        // an interim solution until the issue below is implemented.
        // TODO: MDL-34161 - Fix restore to support course/site tools & submissions.
        $data->typeid = 0;

        $newitemid = $DB->insert_record('lti', $data);

        // Immediately after inserting "activity" record, call this.
        $this->apply_activity_instance($newitemid);
    }

    protected function after_execute() {
        // Add lti related files, no need to match by itemname (just internally handled context).
        $this->add_related_files('mod_lti', 'intro', null);
    }
}
