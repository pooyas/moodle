<?php


/**
 * @package    mod_resource
 * @subpackage backup-lion2
 * @copyright 2015 Pooya Saeedi
 * 
 */

/**
 * Define all the restore steps that will be used by the restore_resource_activity_task
 */

/**
 * Structure step to restore one resource activity
 */
class restore_resource_activity_structure_step extends restore_activity_structure_step {

    protected function define_structure() {

        $paths = array();
        $paths[] = new restore_path_element('resource', '/activity/resource');

        // Return the paths wrapped into standard activity structure
        return $this->prepare_activity_structure($paths);
    }

    protected function process_resource($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();
        $data->timemodified = $this->apply_date_offset($data->timemodified);

        // insert the resource record
        $newitemid = $DB->insert_record('resource', $data);
        // immediately after inserting "activity" record, call this
        $this->apply_activity_instance($newitemid);
    }

    protected function after_execute() {
        // Add choice related files, no need to match by itemname (just internally handled context)
        $this->add_related_files('mod_resource', 'intro', null);
        $this->add_related_files('mod_resource', 'content', null);
    }
}
