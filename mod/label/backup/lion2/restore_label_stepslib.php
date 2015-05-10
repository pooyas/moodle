<?php


/**
 * @package mod
 * @subpackage label
 * @subpackage backup-lion2
 * @copyright 2015 Pooya Saeedi
 * 
 */

/**
 * Define all the restore steps that will be used by the restore_url_activity_task
 */

/**
 * Structure step to restore one label activity
 */
class restore_label_activity_structure_step extends restore_activity_structure_step {

    protected function define_structure() {

        $paths = array();
        $paths[] = new restore_path_element('label', '/activity/label');

        // Return the paths wrapped into standard activity structure
        return $this->prepare_activity_structure($paths);
    }

    protected function process_label($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();

        // insert the label record
        $newitemid = $DB->insert_record('label', $data);
        // immediately after inserting "activity" record, call this
        $this->apply_activity_instance($newitemid);
    }

    protected function after_execute() {
        // Add label related files, no need to match by itemname (just internally handled context)
        $this->add_related_files('mod_label', 'intro', null);
    }

}
