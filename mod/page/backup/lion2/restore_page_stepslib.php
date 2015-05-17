<?php



/**
 * @category  backup
 * @package    mod
 * @subpackage page
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Define all the restore steps that will be used by the restore_page_activity_task
 */

/**
 * Structure step to restore one page activity
 */
class restore_page_activity_structure_step extends restore_activity_structure_step {

    protected function define_structure() {

        $paths = array();
        $paths[] = new restore_path_element('page', '/activity/page');

        // Return the paths wrapped into standard activity structure
        return $this->prepare_activity_structure($paths);
    }

    protected function process_page($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();

        // insert the page record
        $newitemid = $DB->insert_record('page', $data);
        // immediately after inserting "activity" record, call this
        $this->apply_activity_instance($newitemid);
    }

    protected function after_execute() {
        // Add page related files, no need to match by itemname (just internally handled context)
        $this->add_related_files('mod_page', 'intro', null);
        $this->add_related_files('mod_page', 'content', null);
    }
}
