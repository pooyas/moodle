<?php

/**
 * Define all the restore steps that will be used by the restore_book_activity_task
 *
 * @package    mod
 * @subpackage book
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

/**
 * Structure step to restore one book activity
 */
class restore_book_activity_structure_step extends restore_activity_structure_step {

    protected function define_structure() {

        $paths = array();

        $paths[] = new restore_path_element('book', '/activity/book');
        $paths[] = new restore_path_element('book_chapter', '/activity/book/chapters/chapter');

        // Return the paths wrapped into standard activity structure
        return $this->prepare_activity_structure($paths);
    }

    /**
     * Process book tag information
     * @param array $data information
     */
    protected function process_book($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();

        $newitemid = $DB->insert_record('book', $data);
        $this->apply_activity_instance($newitemid);
    }

    /**
     * Process chapter tag information
     * @param array $data information
     */
    protected function process_book_chapter($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();

        $data->bookid = $this->get_new_parentid('book');

        $newitemid = $DB->insert_record('book_chapters', $data);
        $this->set_mapping('book_chapter', $oldid, $newitemid, true);
    }

    protected function after_execute() {
        global $DB;

        // Add book related files
        $this->add_related_files('mod_book', 'intro', null);
        $this->add_related_files('mod_book', 'chapter', 'book_chapter');
    }
}
