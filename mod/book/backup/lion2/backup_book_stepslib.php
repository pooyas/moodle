<?php

/**
 * Define all the backup steps that will be used by the backup_book_activity_task
 *
 * @package    mod_book
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

/**
 * Structure step to backup one book activity
 */
class backup_book_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        // Define each element separated.
        $book = new backup_nested_element('book', array('id'), array(
            'name', 'intro', 'introformat', 'numbering', 'navstyle',
            'customtitles', 'timecreated', 'timemodified'));
        $chapters = new backup_nested_element('chapters');
        $chapter = new backup_nested_element('chapter', array('id'), array(
            'pagenum', 'subchapter', 'title', 'content', 'contentformat',
            'hidden', 'timemcreated', 'timemodified', 'importsrc'));

        $book->add_child($chapters);
        $chapters->add_child($chapter);

        // Define sources
        $book->set_source_table('book', array('id' => backup::VAR_ACTIVITYID));
        $chapter->set_source_table('book_chapters', array('bookid' => backup::VAR_PARENTID));

        // Define file annotations
        $book->annotate_files('mod_book', 'intro', null); // This file area hasn't itemid
        $chapter->annotate_files('mod_book', 'chapter', 'id');

        // Return the root element (book), wrapped into standard activity structure
        return $this->prepare_activity_structure($book);
    }
}
